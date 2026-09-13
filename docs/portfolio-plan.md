# Portfolio Site — Project Plan

## Overview
A personal portfolio site to showcase full-stack development skills (10 years experience: Symfony, Laravel, PHP, MySQL, HTML/JS/TypeScript, Angular), promote services professionally, and link out to LinkedIn, GitHub, Facebook, and live project subdomains.

## Architecture
**Hybrid approach**: Symfony renders all real routes/pages server-side (Twig), React is mounted only in specific "islands" for interactivity. No client-side router — every URL is a real Symfony route, which keeps everything crawlable and fast without needing SPA prerendering workarounds.

- **Backend**: Symfony 8.1, PHP 8.4+ (matches existing subdomain server config)
- **Frontend build**: Vite, via `pentatrion/vite-bundle` (corrected 2026-09-13 — not an actual "Symfony UX" package despite the name; it's the community bundle that fills that role and is what most Symfony+Vite tutorials, including SymfonyCasts', actually use)
- **React**: mounted into specific `<div id="...-root">` containers in Twig, not a full SPA
- **Database**: MariaDB, used for Employment/Education content (see Admin & Database section below, added 2026-09-13) — everything else (hero, services, tech stack, projects) stays hardcoded in `PortfolioContent`/Twig, since it doesn't need editing without a redeploy
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

## Responsive Pass — DONE (2026-09-13)
Build Order step 7. Verified with real Playwright screenshots at iPhone 12 width (390px), a mid-size 700px width, and checked `scrollWidth` vs `clientWidth` on all six pages (zero horizontal overflow anywhere) rather than guessing from the CSS alone.

- **Nav**: below 40rem, a pure-CSS checkbox-driven hamburger toggle replaces the wrapped-links layout that existed before (links used to break across two uneven rows) — no JS needed, no new dependency for something this simple.
- **Hero**: below 48rem, the two-column asymmetric layout (main text + tech-stack panel) collapses to one column and hides the panel (already built during the backend pass, confirmed still correct here).
- **Grids** (services, tech stack, projects, image galleries): already responsive via `repeat(auto-fit, minmax(...))`, no changes needed — collapse to single column naturally as the viewport narrows.
- **Forms**: contact form fields are block-level/full-width already, no fixed widths to break.

## SEO Pass — DONE (2026-09-13)
Build Order step 8. Most of the checklist was already satisfied during the backend build (meta/OG/Twitter/JSON-LD/sitemap/robots — see Backend & Templates above); this pass covered the remaining items:

- **Semantic HTML / heading hierarchy**: audited — every page has exactly one `<h1>`, `<h2>`s nest correctly under it, nothing skips a level.
- **Image optimization**: the case-study screenshots were served at their original capture resolution (up to 1280×1003) despite displaying at a few hundred px in the grid — 760KB total across 7 images. Resized to a 640px max-width (2x a typical display slot, covers retina) and re-encoded; PNG fallback dropped to ~106KB total, plus WebP versions at ~68KB total served via `<picture>`/`<source type="image/webp">`. `PortfolioContent::getProjects()` now carries real `width`/`height` per image (not just a path) so the `<img>` tags can declare accurate intrinsic dimensions — needed to actually prevent layout shift, since `width` alone does nothing once CSS forces `width: 100%`; browsers derive the right aspect ratio from the width/height *attributes* automatically as long as CSS doesn't also set an explicit `height`.
- **Alt text**: already present on every image (per-image label derived from filename, e.g. "Miniature Collection Tracker — Army List screenshot"), confirmed nothing site-wide is missing it.
- **Lazy-loading**: below-fold project screenshots already had `loading="lazy"` from the backend pass.
- **JS bundle size**: previously a single shared Vite entry (`app`) loaded React + both islands' code on *every* page, even pages with no interactive element (home/services/tech-stack/experience). Split into three entries — `app` (CSS only, ~0KB JS), `contact`, and `gallery` — each page now loads only what it actually uses via a `javascripts` block override per template. Verified via the built manifest and `curl`: home/services/tech-stack/experience ship zero React; only `/contact` loads the contact bundle and only `/projects` loads the gallery bundle.
- Not done: submitting to Google Search Console (post-launch only, no live domain yet).

## Cross-Browser Testing — DONE (2026-09-13)
Build Order step 9. Ran the full functional suite (all 6 pages load, contact form fills+submits+shows success, gallery lightbox opens/closes, mobile nav toggle opens) through real Playwright-driven Chromium, Firefox, and WebKit — not just Chromium as in earlier passes. Zero console/page errors on any engine. Also screenshotted the homepage in Firefox and WebKit for visual comparison — pixel-identical to Chromium at 1280px width, no engine-specific layout or font-rendering issues.

## Admin & Database — DONE (2026-09-13)
All 9 Build Order steps were done and the site was working entirely off hardcoded content when the
need for this came up: real Employment/Education history needs to be editable without a redeploy,
plus richer per-course project links as old university projects get redeployed as subdomains over
time. That's a real, ongoing editing need — the "Database: none required unless..." condition in
Architecture above is now met, so this reverses that earlier no-DB decision (for just this content;
everything else stays hardcoded).

### Schema
- **`EmploymentEntry`**: `startDate`, `endDate` (null = current), `companyName`, `companyTitle`,
  `description` (freetext — deliberately not split into more fields, per direct instruction), `position`.
- **`EducationEntry`**: `startDate`, `endDate`, `university`, `qualification`, `position`.
- **`EducationCourse`** (many-to-one to `EducationEntry`, cascade delete): `name`, `grade`,
  `githubUrl`, `domainUrl`, `otherUrl`, `position` — one row per course/module taken during a
  degree, each with its own optional GitHub/live/other links, so old coursework projects can link
  out as they get redeployed as real subdomains.
- **`User`** (`app_user` table): email + hashed password + roles, for admin login only — no
  public-facing accounts exist or are planned.

Iterated on this schema twice with the user before migrating (course-level "uni" field turned out
to be redundant with the parent entry's university, dropped after asking rather than guessing a
third time) — cheap to get right before running a migration, expensive after.

### Auth
Symfony's built-in `form_login` (`security.yaml`), not a custom authenticator — this is a single
hardcoded-role admin account, the simplest fit already built into SecurityBundle. `access_control`
gates `^/admin` behind `ROLE_ADMIN`; `/login` is explicitly `PUBLIC_ACCESS`. Login/logout live in
`SecurityController`, template at `templates/security/login.html.twig` (styled via the existing
`.contact-form` CSS classes rather than new ones).

**Creating the real admin account**: `docker compose exec -it php php bin/console app:create-admin-user <email>` —
prompts for a hidden password interactively (never accepted as a CLI argument, so it never ends up
in shell history or, since Claude Code sees its own tool output, in a conversation transcript
either). Run this yourself in your own terminal; needs `-it` for the interactive prompt to work.

### Admin CRUD
`src/Controller/Admin/` — `DashboardController` (`/admin`), `EmploymentController`
(`/admin/employment`, standard index/new/edit/delete), `EducationController`
(`/admin/education/...` plus nested `/admin/education/{id}/courses/...` for per-degree courses).
Symfony Form + Validator throughout, matching every other form in the app. Courses are managed as
their own small CRUD scoped to a parent education entry, not a JS-driven inline collection —
simpler to get right and to test without needing to verify client-side add/remove behavior.

### Public-facing change
`/experience` was rebuilt from a plain `<ol>` timeline to a card grid (`.service-card`, reusing the
Services page's visual language) for both Employment and Education, since a real DB-backed content
type warranted looking less like a placeholder list. Each education card shows its courses inline
with grade and any GitHub/live/other links.

### Padlock
Top-right of the nav (`_nav.html.twig`, after the Contact button) — a plain inline SVG lock icon
linking straight to `/admin`. No visible state change whether logged in or out: unauthenticated,
`access_control` redirects it to `/login`; authenticated, it opens the dashboard directly.

### Testing
`doctrine:database:create --env=test` + `doctrine:migrations:migrate --env=test` set up a real
`portfolio_test` database (the `symfony` DB user needed `GRANT` from root first — it only had
privileges on the main `portfolio` schema by default). `tests/Controller/Admin/` covers: anonymous
`/admin` redirects to `/login`; an authenticated request (via `loginUser()`, no real login-form
submission needed) succeeds; and full create→edit→delete round trips for both Employment and
Education-with-a-nested-Course, asserting the public `/experience` page reflects each change. 14
tests, 44 assertions, all passing.

### Verified live (Playwright, real browser)
Logged in through the actual login form (not `loginUser()`), created a real employment entry and
an education entry with a course through the real admin UI, confirmed both appear correctly on the
public `/experience` page as cards. The throwaway test account and test rows created for this were
deleted from the dev database afterward — they were never meant to be real content.

### Known gaps
- No `npm run dev`/HMR verified (same standing gap as the React Islands section above).
- The 4 existing hardcoded arrays in `PortfolioContent` (services, tech stack, projects, hero) were
  deliberately left as-is — no stated need to edit those without a redeploy yet.

## Deployment Prep — DONE (2026-09-13)
A dry run of the actual Hostinger deployment process (Build Order step is done, real domain not
live yet), done in an isolated copy so it couldn't disturb the working dev environment/vendor.

- **Gap found and fixed**: unlike `warhammer`/`cyoa`, this repo had no `symfony/apache-pack`
  installed, so there was no `public/.htaccess`. Hostinger's file-manager hosting is Apache-based
  (confirmed by the sibling projects both needing it) — without it, only `/` would have worked
  after upload; every other route (`/services`, `/contact`, `/admin`, etc.) would 404, since nothing
  server-side rewrites requests to `index.php` the way the local `nginx.conf` does. Installed via
  `composer require symfony/apache-pack` (Flex recipe, not hand-written) — generated
  `public/.htaccess` matching the sibling projects' setup. Confirmed `bin/phpunit` still green
  (14 tests) and `git diff` on `bin/console`/`bin/phpunit` was only a file-mode change (0644→0755
  from the recipe's own script), nothing content-wise.
- **Dry run method**: copied the whole app into the `php` container's own filesystem (`/tmp/deploy-dryrun`,
  *not* the bind-mounted volume, so nothing written there ever touches the host repo or the working
  dev `vendor/`), then ran the exact production sequence from the Deployment Workflow section below
  against that copy.
- **Gotcha caught**: running `composer install --no-dev --optimize-autoloader` *before* a
  `.env.local` with `APP_ENV=prod` exists breaks the install itself — Composer's own post-install
  `cache:clear` script runs against whatever `APP_ENV` is currently active (defaults to `dev` from
  the committed `.env`), and by then `--no-dev` has already removed dev-only packages like
  `symfony/debug-bundle`, so cache warmup crashes with `Class "Symfony\Bundle\DebugBundle\DebugBundle"
  not found`. **Fix / real-deploy ordering that matters**: create `.env.local` with `APP_ENV=prod`
  set *first*, then run `composer install --no-dev`.
- **Verified clean** once ordered correctly: `composer install --no-dev --optimize-autoloader`,
  `cache:warmup --env=prod`, and `lint:container --env=prod` all passed with no errors. Served the
  warmed build with PHP's built-in server (`APP_ENV=prod APP_DEBUG=0`) and curled real routes: `/`
  → 200, `/experience` → 200 and correctly rendered your real saved job entry from the database,
  `/admin` → 302 redirect to `/login` (access control still enforced under prod). No manifest/Vite
  asset errors — the existing `public/build/` output from `npm run build` is prod-ready as-is.

### What's still needed from you before the real upload (can't be done for you — needs your
### Hostinger account/credentials, not something I have access to)
A production `.env.local` (git-ignored, uploaded alongside the app, never committed) needs real
values for:
- `APP_ENV=prod`
- `APP_SECRET` — generate a fresh one for production, don't reuse the dev value committed in
  `compose.yaml` (`php bin/console secrets:generate-keys` or simply a new random 32-hex string —
  it just needs to be unique and secret, not derived from anything).
- `DATABASE_URL` — the real MySQL credentials Hostinger gives you for this subdomain's database
  (host/user/pass/dbname from their control panel — different from the local `symfony`/`symfony`
  dev creds).
- `MAILER_DSN` — real SMTP credentials so the contact form can actually send mail in production
  (Hostinger's own SMTP, or an external one like SendGrid/Mailgun/Gmail SMTP — `null://null`/Mailpit
  were dev-only stand-ins).
- `CONTACT_EMAIL` is already real (`martynwoollardwebdev@gmail.com`) and doesn't need changing.

Then follow the Deployment Workflow steps below as written (they're the exact sequence just
verified in the dry run) — the one addition is **run `doctrine:migrations:migrate --env=prod`
after first upload** to create the `app_user`/`employment_entry`/`education_entry`/`education_course`
tables on the real production database (they don't exist there yet), then run
`app:create-admin-user` once against production the same way you did locally, to get a real admin
login on the live site.

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
- **Experience**: brief timeline, 10 years, key milestones, plus an Education sub-section — both
  are DB-backed cards, editable via `/admin` (added 2026-09-13, see Admin & Database section)
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
7. Responsive pass (mobile-first, real breakpoints) — DONE (2026-09-13), see Responsive Pass section above
8. SEO pass (see checklist above) — DONE (2026-09-13), see SEO Pass section above
9. Cross-browser/device testing — DONE (2026-09-13), see Cross-Browser Testing section above

## Deployment Workflow — GitHub Actions + FTP (revised 2026-09-13)
**Superseded the original manual file-manager plan below** once `warhammer`'s `.github/workflows/`
was found to already have a proven, working pattern for this exact Hostinger account — no SSH
access, so it deploys over FTP from CI rather than clicking through the file manager, and generates
migration SQL to paste into phpMyAdmin rather than running migrations directly (no console access
either). Replicated for `portfolio` as `.github/workflows/deploy.yml` and `migration-sql.yml`,
adapted for this app's Vite/`pentatrion` build (no separate `frontend/` dir or AssetMapper compile
step — `npm run build` writes straight to `public/build/`).

### One-time setup (you do this — needs your Hostinger/GitHub access, not something I can do)
Add these as **repository secrets** on `FeatheredFiend/portfolio` (Settings → Secrets and variables
→ Actions) — never paste actual values into chat, just add them directly in GitHub:
- `PROD_APP_SECRET` — a fresh random string, not the dev value committed in `compose.yaml`.
- `PROD_DATABASE_URL` — e.g. `mysql://USER:PASS@HOST:3306/propriet_portfolio?serverVersion=10.11.18-MariaDB&charset=utf8mb4`.
  Get the exact host/user/password from Hostinger's hPanel → Databases (same place `cyoa`'s
  `propriet_cyoa`-style DB was set up) — shared MySQL hosting is very often reachable as `localhost`
  from the app's own PHP, but confirm there rather than assuming.
- `PROD_MAILER_DSN` — e.g. `smtp://martyn%40proprietary-data.com:APP_PASSWORD@HOST:587` (URL-encode
  `@` as `%40` in the username). Get the exact SMTP host/port for `martyn@proprietary-data.com` from
  hPanel → Emails → your domain → Connection details — don't guess this one, mail hosts vary.
- `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD` — FTP credentials for the `portfolio` subdomain's own
  document root (separate from `warhammer`'s FTP secrets, even though they may share the same FTP
  server host).
- `PROD_ADMIN_EMAIL`, `PROD_ADMIN_PASSWORD` — only needed once, for the **Create/reset production
  admin user** workflow below; safe to leave in place afterwards to reset the password later if
  needed, or delete once you're logged in.

### Troubleshooting hit on first real runs (2026-09-13)
- **`Deploy to Hostinger` → "Server sent FIN packet unexpectedly, closing connection"**: happened on
  the FTP step specifically, after all prior steps (composer, env, build, cache warmup) succeeded —
  and on a *later* run, after an earlier run had already succeeded once (24m16s). Root cause: a
  GitHub-hosted runner starts from a clean checkout every time with no memory of what it already put
  on the server, so `FTP-Deploy-Action` was treating every file — thousands of them, most of it
  `vendor/` — as new on every single run, a full resync each time over shared-hosting FTP. That's
  slow (~20+ min) and leaves a long window for the shared host to drop the connection mid-transfer.
  Fixed by caching the action's own `.ftp-deploy-sync-state.json` between runs (`actions/cache`,
  keyed by run id with a prefix restore-key — the standard "growing cache" pattern), so normal
  deploys after the next one only transfer real diffs; also bumped `timeout` to 120s and `log-level`
  to `verbose` for better signal if it happens again. The very next run still does a full resync
  (no cached state exists yet to restore), same as before.
- **`Create/reset production admin user` workflow abandoned** — first attempt hit `getaddrinfo for
  HOST failed` (the `PROD_DATABASE_URL` secret still had the literal placeholder text from this
  doc). After fixing that, it hit `SQLSTATE[HY000] [2002] No such file or directory` instead: the DB
  host was `localhost`, which makes MySQL's client library open a *local Unix socket* rather than a
  network connection — correct for PHP running on Hostinger's own server, but meaningless from a
  GitHub Actions runner (a different machine entirely, no such socket exists there). Fixing this
  properly would need Hostinger's Remote MySQL access enabled for `propriet_portfolio` (likely
  requiring `%`/any-host, since GitHub-hosted runner IPs aren't fixed) plus the real external
  hostname — not pursued, since a phpMyAdmin one-off is simpler and needs neither. **Actual working
  approach**: `docker compose exec php php bin/console security:hash-password` locally (hidden
  prompt, password never leaves your machine) to get a hash, then run in phpMyAdmin against
  `propriet_portfolio`:
  ```sql
  INSERT INTO app_user (email, roles, password)
  VALUES ('you@example.com', JSON_ARRAY('ROLE_ADMIN'), 'PASTE_HASH_HERE')
  ON DUPLICATE KEY UPDATE roles = JSON_ARRAY('ROLE_ADMIN'), password = 'PASTE_HASH_HERE';
  ```
  `ON DUPLICATE KEY UPDATE` (keyed on `email`'s unique index) makes this safe to re-run to reset the
  password later. `.github/workflows/create-admin.yml` is left in the repo in case Remote MySQL
  access gets enabled later, but isn't the working path today.

### Every deploy after that
1. Push/merge the changes you want live to `main`.
2. If this deploy adds/changes a migration: run the **Generate migration SQL** workflow (Actions tab
   → select it → Run workflow), copy the printed SQL, paste and run it in Hostinger's phpMyAdmin
   against `propriet_portfolio`. First-ever run needs the full schema (all tables); later runs only
   need the new migration's block, since earlier statements are already applied.
3. Run the **Deploy to Hostinger** workflow (same Actions tab, `workflow_dispatch`) — installs deps,
   writes `.env.local` from the secrets above, builds Vite assets, warms the prod cache, and FTPs
   everything (minus tests/docs/dev-only files) to the subdomain's document root.
4. First deploy only: run the **Create/reset production admin user** workflow (same Actions tab) —
   calls `app:create-admin-user` against the real production database using the `PROD_ADMIN_EMAIL`/
   `PROD_ADMIN_PASSWORD` secrets, via a new `--password-env` option added to that command
   specifically for this (password only ever exists as a masked GitHub secret, never a logged
   argument or prompt output). Safer than trying to do this through phpMyAdmin, since it needs the
   real password hasher, not just an INSERT. Re-runnable any time to reset the password later.

<details>
<summary>Original manual file-manager plan (superseded, kept for reference)</summary>

1. Develop locally inside the Docker Compose stack (`docker compose up`, `npm run dev` for Vite HMR against the containerized backend)
2. Set production `.env.local` FIRST (`APP_ENV=prod`, fresh `APP_SECRET`, real `DATABASE_URL`, real `MAILER_DSN`) — must exist before step 3, or composer's own post-install cache:clear script crashes (see Deployment Prep gotcha above).
3. `composer install --no-dev --optimize-autoloader`
4. `npm run build`
5. Warm cache locally: `php bin/console cache:warmup --env=prod`
6. Upload full project via file manager (`vendor/`, `public/build/`, `config/`, `src/`, `.env.local`, etc.)
7. Point the subdomain's document root at `/public`
8. `symfony/apache-pack`'s `.htaccess` in `public/` handles routing through `index.php` — no extra rewrite rules needed (no client-side router to account for)
9. Run `php bin/console doctrine:migrations:migrate --env=prod` once, against the real production database, to create the `app_user`/`employment_entry`/`education_entry`/`education_course` tables (they don't exist there yet)
10. Run `php bin/console app:create-admin-user <email> --env=prod` once, the same way as locally, to get a real admin login on the live site

</details>

## Open Items (fill in before/during build)
- Confirm exact PHP version + any module availability on the hosting plan (already confirmed: 8.4)
- ~~Real URLs for email, LinkedIn, GitHub, Facebook, and each project subdomain~~ — DONE
  (2026-09-13): name (Martyn Woollard), email, LinkedIn, Facebook, and both subdomain URLs are real now.
- Real employment and education history — no longer hardcoded placeholders to fill in; as of
  2026-09-13 this is a database (see Admin & Database section), currently empty. Add your real
  employment and both degrees (MSc + BEng (Hons) Computer Science, institution/dates/courses) via
  `/admin` (padlock icon, top-right nav) once you've created your own admin login.
- Final service list/copy
- Project case-study content and screenshots
