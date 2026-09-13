# Portfolio Site — Project Plan

## Overview
A personal portfolio site to showcase full-stack development skills (10 years experience: Symfony, Laravel, PHP, MySQL, HTML/JS/TypeScript, Angular), promote services professionally, and link out to LinkedIn, GitHub, Facebook, and live project subdomains.

## Architecture
**Hybrid approach**: Symfony renders all real routes/pages server-side (Twig), React is mounted only in specific "islands" for interactivity. No client-side router — every URL is a real Symfony route, which keeps everything crawlable and fast without needing SPA prerendering workarounds.

- **Backend**: Symfony 8.1, PHP 8.4+ (matches existing subdomain server config)
- **Frontend build**: Vite, via `pentatrion/vite-bundle` (corrected 2026-09-13 — not an actual "Symfony UX" package despite the name; it's the community bundle that fills that role and is what most Symfony+Vite tutorials, including SymfonyCasts', actually use)
- **React**: mounted into specific `<div id="...-root">` containers in Twig, not a full SPA
- **Database**: none required unless project data should be editable without redeploying — otherwise hardcode project/portfolio data in Twig/YAML config
- **Hosting/deployment**: Hostinger, file manager upload (no SSH/FTP), same `/public` document-root pattern as other subdomains (cyoa.proprietary-data.com, Warhammer gallery)

## Repository & Local Development Environment — DONE (2026-09-13)
Bootstrapped the same way as the `warhammer` and `cyoa` repos — a WSL-hosted Docker Compose stack, not a bare `symfony server` process.

### GitHub repo
- Reused the existing `FeatheredFiend/portfolio` repo (created 2022, but was just an auto-generated `.gitattributes` and a single "Initial commit" — nothing of substance, so built the fresh Symfony app straight on top rather than creating a new repo)
- Cloned into WSL at `~/projects/portfolio`
- Symfony's own generated `.gitignore` covers `/vendor/`, `/var/`, `.env.local`, etc.; nothing added yet for `node_modules/`/`public/build/` since Vite isn't wired up yet (Build Order step 5)

### Docker Compose — `compose.yaml` (single file, no override files)
- **`web`** — `nginx:alpine` → `php` on port 9000. Host port **8082**.
- **`php`** — `thecodingmachine/php:8.4-v4-fpm`.
- **`database`** — `mariadb:10.11`, db/user/pass `portfolio`/`symfony`/`symfony`, host port **3309** (warhammer=3307, cyoa=3308). Included from the start now (not deferred) — confirmed reachable via `doctrine:dbal:run-sql "SELECT 1"` and `bin/console lint:container`.
- **`mailer`** — `axllent/mailpit`, not `mailcatcher` (cyoa's choice) — swapped because Symfony's own `symfony/mailer` Flex recipe defaults to mailpit and it's the actively-maintained option; mailcatcher is stale. SMTP on **1025**, web UI on **8025** (confirmed HTTP 200).

**Gotcha hit during bootstrap, same as cyoa's stale-recipe trap**: installing `webapp` (which pulls in `doctrine/doctrine-bundle` and `symfony/mailer`) caused Flex to silently write a `compose.override.yaml` — Postgres port on `database`, and a second `mailer` service overriding the intentional one — which Docker Compose auto-merges regardless of filename. Fixed by folding the useful bits (mailpit) into `compose.yaml` directly and deleting the override file, so there's one source of truth. Also had to hand-fix `.env`'s `DATABASE_URL`, which the doctrine-bundle recipe had pointed at a Postgres DSN by default.

`nginx.conf` — copied the warhammer/cyoa template verbatim.

Committed straight to `.env` (matching warhammer's convention, not `.env.local`, since these are non-sensitive local dev creds): `DATABASE_URL=mysql://symfony:symfony@127.0.0.1:3309/portfolio?...`. The container-internal DSN (`database:3306`) is set directly in `compose.yaml`'s `php` service environment.

### Verified working
- `curl http://localhost:8082/` → HTTP 200/404-with-Symfony's-own-page (no routes defined yet, expected) served through nginx → php-fpm → Symfony kernel
- `bin/console lint:container` → OK
- `bin/console doctrine:dbal:run-sql "SELECT 1"` → connects fine
- `doctrine:schema:validate` reports a "not in sync" error — this is a known harmless Doctrine quirk when there are zero entity classes yet (`schema:update --dump-sql` confirms "No Metadata Classes to process"); resolves naturally once real entities exist
- Mailpit UI reachable at `localhost:8025`

Everything left uncommitted in git, as usual, pending explicit go-ahead to commit.

### Still to do (Build Order steps 2+)
- Vite + `symfony/webapp`'s frontend wiring, actual site content/routes, React islands — not started yet

## Case-Study Assets — DONE (2026-09-13)
- **cyoa**: reused 4 existing screenshots straight from `cyoa`'s own in-app help section (`public/images/help/`) — `homepage.png`, `gamebooks.png`, `play-story.png`, `play-combat.png` — copied into `content/copy.md`'s companion assets at `public/images/portfolio/cyoa/` in the portfolio repo. No new capture needed.
- **warhammer**: no equivalent existed, so captured fresh screenshots of the real public-facing React frontend (not the plain Bootstrap `/admin` CRUD backend, which isn't portfolio-worthy) against real DB content — the "Ultramarines 2nd Company" army with its two units. Saved to `public/images/portfolio/warhammer/`: `army-list.png`, `army-detail.png`, `unit-detail.png`.
  - Had no browser-automation tooling installed; ended up installing Playwright + running headless Chromium via Microsoft's official `mcr.microsoft.com/playwright` Docker image (host WSL lacked the shared libraries `--with-deps` needs and there's no passwordless sudo to install them) — see [[feedback-project-bootstrap-pattern]] or [[project-warhammer-app]] memory for the exact networking workaround (CORS only allows `localhost`/`127.0.0.1` origins, so the containerized browser needed `--host-resolver-rules` to make `localhost` resolve to the WSL host while keeping the Origin header intact).
  - **Flagged, not fixed**: the pages are visually sparse with only one army/two units seeded (lots of empty whitespace) and the `army-detail.png` shot has a slightly odd-looking thumbnail crop on the "Tactical Squad" tile. Worth deciding whether to crop these tighter, add more demo data before a final shoot, or leave as an authentic in-progress look.
  - Created a disposable `portfolio-demo@local.test` admin account via `app:create-admin-user` for this session (turned out not to be needed — the public frontend's `/api/*` is unauthenticated — but it still exists in the local DB if not cleaned up).

## Backend & Templates — DONE (2026-09-13)
Build Order step 4. All six public pages are real Symfony routes rendering Twig, backed by content pulled from `content/copy.md` via a small `App\Content\PortfolioContent` service (injected everywhere as the Twig global `content`, and directly in controllers for page-specific data).

- **Routes**: `app_home` (`/`), `app_services`, `app_tech_stack`, `app_projects`, `app_experience`, `app_contact` (all GET, thin controllers under `src/Controller/`), plus `api_contact_submit` (`POST /api/contact`) and `app_sitemap` (`GET /sitemap.xml`).
- **Contact form endpoint**: `App\Dto\ContactRequest` (readonly, `Assert` constraints) bound via `#[MapRequestPayload]`; validation failures return RFC 7807 JSON automatically when the client sends `Accept: application/json` (422 with `violations`). Valid submissions are emailed via `MailerInterface` to `%env(CONTACT_EMAIL)%` (placeholder `you@example.com` in `.env` — replace before going live).
  - **Gotcha fixed**: `symfony/mailer` + `symfony/doctrine-messenger` were both installed, so Flex's default routing sent `SendEmailMessage` through the `async` (Doctrine) transport — which has no consumer running in this stack and no `messenger_messages` table, so every send 500'd. Fixed by routing mail/notifier messages to a `sync` transport in `config/packages/messenger.yaml` instead of standing up a worker nobody asked for.
- **SEO**: per-page `title`/`meta_description` Twig blocks, OG + Twitter meta, `<link rel="canonical">`, a `Person` JSON-LD block in `base.html.twig` (real social URLs only — `PortfolioContent::getSameAsUrls()` filters out `#` placeholders so the schema doesn't ship broken links), `public/robots.txt`, and a `SitemapController` that generates `/sitemap.xml` from the actual named routes (single source of truth, can't drift from the real route list).
- **Design Direction applied**: dark theme, one accent color (`--color-accent`), monospace touches on eyebrows/outcomes/timeline years/footer — plain CSS in `assets/styles/app.css`, no framework. Hero uses the asymmetric two-column layout with a small monospace "tech-stack" panel filling the second column (real data, not decorative filler).
- **Tests**: `tests/Controller/SiteControllerTest.php` (all six pages return 200, sitemap lists real URLs) and `tests/Controller/ContactControllerTest.php` (valid submission accepted, invalid rejected with 422) — `php bin/console phpunit` / `bin/phpunit`, 10 tests passing.
- **Verified visually**: screenshotted all six pages with Playwright run directly from the Windows host (not the WSL-Docker dance in [[feedback-wsl-docker-process-gotchas]] — that's only needed for a bare dev server with no Docker port mapping; this stack's nginx already publishes `8082:80`, so Docker Desktop bridges it straight to Windows' own `localhost`).

## React Islands — DONE (2026-09-13)
Build Order steps 5–6. Installed `pentatrion/vite-bundle` via `composer require` (had to enable `extra.symfony.allow-contrib` first — Flex ignores contrib recipes by default and this one lives in `recipes-contrib`, not `recipes`) and removed `symfony/asset-mapper` + the unused `symfony/stimulus-bundle`/`symfony/ux-turbo` skeleton defaults (neither was used by any page built in the previous session) so there's exactly one JS/CSS pipeline, not two competing ones.

- **Gotcha hit**: `composer remove` on a package with a Flex recipe deletes every file listed in that recipe's manifest, even ones since hand-rewritten — it silently deleted the CSS/JS written in the previous session. Recovered in full only because the content was still visible earlier in the same conversation. See [[feedback-flex-uninstall-deletes-edited-files]] — worth committing to git early next time so there's a real safety net (nothing is committed in this repo yet).
- **Entry point**: `assets/app.jsx` (renamed from `.js` to allow JSX directly in the entry) imports `styles/app.css` and conditionally mounts two islands by checking for their root elements — same file serves every page, only mounts what that page actually has.
- **Contact form** (`assets/react/ContactForm.jsx`) — controlled inputs, `fetch()` to `/api/contact` with `Accept: application/json`, maps 422 `violations` back to per-field errors, shows a success state on 200. Verified end-to-end with a real Playwright browser run: fill → submit → success message → message present in Mailpit.
- **Gallery lightbox** (`assets/react/Lightbox.jsx`) — progressively enhances the server-rendered `<img>` tags already on `/projects` (event delegation on document, not a re-render of the gallery) so the images stay in the initial HTML for SEO/crawlability; only the modal overlay is React-rendered, mounted into a single `#lightbox-root` div.
- **Build**: `npm run build` (run directly in WSL via the project's usual nvm-managed Node — no Docker container for the Node tooling, matching the `warhammer` project's convention) outputs `public/build/`, which `vite_entry_script_tags()`/`vite_entry_link_tags()` in `base.html.twig` reference. Dev-server/HMR mode (`npm run dev`) was not exercised this session — production build only, re-run `npm run build` after any asset change until that's set up.
- Verified with Playwright (real Chromium, zero console errors): both islands mount, lightbox opens/closes on click and Escape, contact form fully submits.

### Known gaps / next session
- No `npm run dev` / HMR workflow verified yet — rebuild with `npm run build` after any change to `assets/`.
- `content/copy.md`'s bracketed placeholders (name, employment history, real social/subdomain URLs, contact email) are still open — see Open Items below.
- Responsive pass (Build Order step 7), SEO pass beyond what's already done (step 8), and cross-browser testing (step 9) not yet done.

## Where React Is Used (islands only)
- Contact form (client-side validation + async submit to a Symfony API endpoint)
- Portfolio gallery (filtering, lightbox for project screenshots)
- Optional: subtle scroll-triggered animations

Everything else (hero, services copy, experience timeline, nav, footer) stays plain Twig/HTML for SEO and simplicity.

## Site Structure / Pages
- **Home**: hero (name, title, one-line value prop, CTA)
- **Services**: 3–5 cards, problem-first framing, outcome-based language (not just tech names)
- **Tech stack**: visual grid grouped by category (Backend, Frontend, DB, Tools)
- **Portfolio/Projects**: links out to live subdomains as real demos, with screenshots + short case-study blurbs (problem → what was built → tech used)
- **Experience**: brief timeline, 10 years, key milestones
- **Contact**: form (async submit to Symfony backend) + direct links to email, LinkedIn, Facebook
- **Footer**: social links, subdomain links, GitHub, copyright

## Contact / Social Links
Placeholders to fill in once built (use `#` or a `TODO` comment as href):
- Email
- LinkedIn
- Facebook
- GitHub
- Project subdomain links

## Service Promotion Guidance
- Lead each service with the client's problem, not the tech stack (e.g. "Slow, outdated PHP app dragging down your business?" rather than "I know Laravel")
- Use outcome-based language: reduced load times, scalable APIs, maintainable codebases
- One clear CTA per section — avoid multiple competing buttons
- Optional "how I work" section: discovery → build → deliver, to build trust without hard-selling

## Design Direction
Pick one distinctive design element (asymmetric hero layout, a signature accent color, monospace touches nodding to code, subtle scroll animations) rather than reinventing every UI convention. Keep navigation, spacing, and forms standard — familiarity there is what keeps it "easy to use" despite looking distinctive.

## SEO Checklist
- Server-rendered meta titles/descriptions per page (set in Twig/controllers, not injected via JS)
- Open Graph + Twitter card tags
- Schema.org `Person` / `ProfessionalService` JSON-LD in base layout
- `sitemap.xml` + `robots.txt`
- Semantic HTML, proper heading hierarchy, alt text on all images
- Optimize images, lazy-load below-fold content, minimize JS bundle size
- Submit to Google Search Console post-launch

## Build Order
1. Bootstrap: GitHub repo + Docker Compose stack (see Repository & Local Development Environment above), confirm the bare Symfony skeleton boots at `localhost:8082` — DONE (2026-09-13)
2. Write content/copy first (services, about, project blurbs) before touching code — DRAFTED (2026-09-13), see `content/copy.md` in the repo. Still needs: your name/title, real Experience timeline (employment history — not something to guess at), and the two project subdomain URLs/screenshots.
3. Wireframe/design — SKIPPED in favour of building straight from the Design Direction section above (asymmetric hero + accent color + monospace touches); no Figma file exists
4. Symfony backend: routing, Twig shells, contact form endpoint, per-route meta tag logic — DONE (2026-09-13), see Backend & Templates section below
5. React components via Vite: contact form, portfolio gallery/lightbox — DONE (2026-09-13), see React Islands section below
6. Integrate React into Twig templates (mount points per page) — DONE (2026-09-13), folded into step 5
7. Responsive pass (mobile-first, real breakpoints)
8. SEO pass (see checklist above)
9. Cross-browser/device testing

## Deployment Workflow (no SSH, file manager only)
This is the production release process, separate from the Docker Compose stack used for local dev (see above).
1. Develop locally inside the Docker Compose stack (`docker compose up`, `npm run dev` for Vite HMR against the containerized backend)
2. When ready: `composer install --no-dev --optimize-autoloader`
3. `npm run build`
4. Set production `.env.local` (DB creds if any, `MAILER_DSN`, `APP_ENV=prod`)
5. Warm cache locally: `php bin/console cache:warmup --env=prod`
6. Upload full project via file manager (`vendor/`, `public/build/`, `config/`, `src/`, etc.)
7. Point the subdomain's document root at `/public`
8. Symfony's default `.htaccess` in `public/` handles routing through `index.php` — no extra rewrite rules needed (no client-side router to account for)

## Open Items (fill in before/during build)
- Confirm exact PHP version + any module availability on the hosting plan (already confirmed: 8.4)
- Real URLs for email, LinkedIn, Facebook, GitHub, and each project subdomain
- Final service list/copy
- Project case-study content and screenshots
