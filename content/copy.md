# Portfolio Site — Content & Copy (Draft)

Per Build Order step 2 in `docs/portfolio-plan.md`: content written before any Twig/routes exist. This
is the source text to wire into templates/YAML config in step 4. Anything in `[brackets]` needs
your input before it's real.

## Home / Hero
- **Name**: Martyn Woollard
- **Title**: Full-Stack Developer — PHP, Symfony & Laravel
- **Value prop**: Ten years turning slow, fragile PHP apps into fast, maintainable ones — and
  building new tools from scratch when there isn't one yet.
- **CTA** (one, per Service Promotion Guidance): "View My Work" → Portfolio page

## Services
Four cards, problem-first. One CTA for the whole page (bottom: "Let's talk" → Contact), not one
per card.

1. **Your PHP app still runs — barely.**
   Aging Symfony/Laravel codebases don't have to mean rewrites. I upgrade PHP and framework
   versions safely, one major version at a time, with real regression checks at every step — no
   "it works on my machine" guesswork.
   *Outcome: fewer security warnings, faster page loads, a codebase your next developer won't
   dread.*

2. **You need something built, not just discussed.**
   Custom internal tools, admin dashboards, or customer-facing apps — built full-stack with
   Symfony/Laravel on the backend and React or Angular where the UI actually needs it.
   *Outcome: a working tool in weeks, not a requirements doc that never ships.*

3. **Your API falls over under real traffic.**
   Slow queries, N+1 problems, endpoints that were never meant to serve this much load. I profile,
   index, cache, and restructure until the numbers hold up.
   *Outcome: APIs that scale with your product instead of becoming the bottleneck.*

4. **Nobody on the team wants to touch that codebase.**
   Undocumented legacy systems are a liability every time someone leaves. I do focused audits —
   what's fragile, what's safe to change, what should be rewritten — and leave the team with a
   map, not just a report.
   *Outcome: less tribal knowledge, more confidence making changes.*

### How I Work (optional section, per plan)
1. **Discovery** — a short call to understand the actual problem, not just the feature request.
2. **Build** — regular check-ins, working software early, not a single reveal at the end.
3. **Deliver** — deployed, documented, and handed off cleanly, including a walkthrough so your
   team isn't stuck depending on me.

## Tech Stack
- **Backend**: PHP, Symfony, Laravel
- **Frontend**: React, Angular, TypeScript, JavaScript, HTML/CSS
- **Database**: MySQL, MariaDB
- **Tools**: Docker, Git/GitHub, Vite, GitHub Actions (CI/CD)

## Portfolio / Projects
### Miniature Collection Tracker
- **Problem**: Tracking a growing tabletop miniature collection — armies, units, painting
  progress, and game history — in spreadsheets doesn't scale and leaves no visual record.
- **What was built**: A full-stack tracker with user accounts, army/unit management, game
  logging, and photo galleries for painted miniatures.
- **Tech used**: Symfony (API/backend), React + Vite (frontend), MySQL, deployed via GitHub
  Actions CI/CD.
- **Links**: https://warhammer.proprietary-data.com · screenshots in `public/images/portfolio/warhammer/`

### Choose-Your-Own-Adventure Builder
- **Problem**: Writing a branching "choose your own adventure" gamebook by hand means tracking
  dozens of paragraphs, battles, and item/character state from memory — error-prone past a
  certain size.
- **What was built**: A server-rendered authoring tool for building and playing branching
  adventures — paragraphs, battles, heroes, equipment, and magic — with full CRUD for authors and
  a playable runtime for readers.
- **Tech used**: Symfony, Twig, MySQL/MariaDB. Actively maintained — recently upgraded across
  three major Symfony versions (6→8) and to PHP 8.4.
- **Links**: https://cyoa.proprietary-data.com · screenshots in `public/images/portfolio/cyoa/`

(Add more entries here as more subdomain projects go live.)

### Games (added 2026-10-15)
Shown first on `/projects` under their own "Games" heading, with a teaser row on the home page.
Each sells the concept first (hook, pitch, features), then the engineering ("Under the hood").
Screenshots are real captures of the live builds, except where a caption says concept art.

**Section intro**: Three original games for the browser, each designed, written and shipped by
me, from the first greybox to the deploy pipeline. Two are playable right now: no download, no
install, just click and play. They're also where I push the habits I bring to client work: game
rules in pure, tested TypeScript kept apart from the rendering, content in validated data files
instead of code, and CI that ships every green push.

#### Tethered Darkness — gothic horror JRPG (playable: regions 1–4 of 6)
- **Hook**: Every grave in Hollowmere has a lantern, and the lanterns keep the dead below.
  Tonight they are going out.
- **Pitch**: A disgraced knight, an occultist and a church cantor are left on a fen jetty by a
  ferryman who won't wait. Up in Broodhollow the churchyard lanterns are dying, the dead are
  climbing out, and somewhere beneath the water a drowned bell screams each time another light
  fails. They follow the sound down. / It's the 16-bit Final Fantasy you grew up with, with the
  dial turned from adventure to dread: fog, candlelight, drowned churches, and things that move
  just past the edge of your lantern. The horror comes from what you can't see, and from what
  the light costs you.
- **Features**: light is a resource (lantern oil, unlit floors make monsters 20% stronger) ·
  real-time turn gauges · learn from the dead (Absorb, Steal, Guard) · no random battles ·
  five hidden charms change the ending · keyboard, gamepad or touch, cloud saves in 3 slots.
- **Under the hood**: TypeScript, Phaser 4, Vite, Zod-checked JSON, Ink dialogue; pure-TS battle
  engine with a seeded RNG and a headless simulator for balancing; Symfony 8.1 API + MySQL for
  accounts and saves; GitHub Actions deploys every green push.
- **Links**: https://tethered-darkness.proprietary-data.com · images in
  `public/images/portfolio/tethered-darkness/`

#### The Village of Suffering — grim isometric RTS (playable: whole loop, final art in progress)
- **Hook**: Villagers dig up the graveyard. The dead rise as skeletons. The skeletons go below
  to fight demons for the organs that make the next army stronger.
- **Pitch**: Your village knows exactly what becomes of its dead, and works for you anyway. By
  night the gravediggers sink the graveyard one level deeper. By day you stitch what they find
  into skeletons, arm them at the forge, and march them down the one grave that breaks open into
  a fresh dungeon at dawn. / Every demon down there drops something worth stitching in: a heart
  for strength and speed, a brain for resistances and a better grip on a weapon. The deeper you
  dig, the stronger the army you can build to dig deeper still, until something on the
  twenty-fifth level wakes up and notices you.
- **Features**: build your army from the dead (6–12 bones, organs, flesh, armour) · a new
  dungeon every dawn, stranded armies dig out · bring your own light · the church, the mob and
  the Red Cardinal · eight jobs, dead villagers rise with a perk · phone-ready touch controls.
- **Under the hood**: TypeScript, Phaser 4; fixed-tick seeded simulation on a grid with A*,
  isometric only in rendering; all content in JSON; a scripted player balances whole seasons in
  the test suite; layered Blender sprites in 8 directions; the same Symfony save API.
- **Links**: https://village-of-suffering.proprietary-data.com · images in
  `public/images/portfolio/village-of-suffering/` (concept art is SDXL, made locally, and
  captioned as such)

#### Life Detected — retro-plus first-person shooter (in development)
- **Hook**: A motion tracker you listen to, and corridors darker than they should be.
- **Pitch**: You hear it before you see it. The tracker sweeps once a second, and every ping
  shows movement, never walls: something is in here with you, and you can't tell where the room
  ends. Creatures give themselves away by sound first, so the audio isn't decoration. It's the
  level design. / It's built the way the best mid-90s shooters were, where every level has a job
  to do, not just an exit to find: get the keycard, destroy the nest, bring the survivors out,
  with a briefing going in and a tally on the way out. Low-poly models under modern lighting
  keep that 1996 feel, and the shadows do the frightening.
- **Features**: the motion tracker · objectives, not just exits · the torch is the main light ·
  instant to play (first level under 15 MB, WebGPU with WebGL 2 fallback).
- **Under the hood**: Three.js WebGPU renderer; pure-TS engine at a fixed 60 Hz with a seeded
  RNG and headless Vitest playthroughs; Zod-checked grid levels; A* creatures; scripted Blender
  and ComfyUI asset pipeline with meshopt and KTX2; one finished level is playtested before the
  campaign.
- **Links**: https://life-detected.proprietary-data.com (holding page) · image in
  `public/images/portfolio/life-detected/`

## Experience & Education
**No longer hardcoded here** — as of 2026-09-13 both live in the database and are managed through
the admin CRUD at `/admin` (padlock icon, top-right nav), not this file. See
`docs/portfolio-plan.md`'s "Admin & Database" section for the schema. Still needs your input either
way — add your real employment history and both degrees (MSc + BEng (Hons) Computer Science,
institution/dates/courses) once you have your own admin login.

Framing line (still hardcoded, in the page template): 10 years full-stack,
PHP/Symfony/Laravel-focused, with MySQL and React/Angular front ends.

## Contact
- **Headline**: Have a project or a problem? Let's talk.
- **Form fields**: Name, Email, Message (client-validated, async submit)
- **Direct links**: martynwoollardwebdev@gmail.com · linkedin.com/in/martyn-woollard-347b8b128 ·
  GitHub (`FeatheredFiend`) · Facebook (still needs a real link)

## Footer
- Social: LinkedIn, Facebook, GitHub
- Projects: miniature tracker, CYOA builder subdomain links
- © [Year] Martyn Woollard
