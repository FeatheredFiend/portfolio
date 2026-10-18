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

### Games (added 2026-10-15, updated 2026-10-18)
Shown first on `/projects` under their own "Games" heading, with a teaser row on the home page.
Each sells the concept first (hook, pitch, features), then the engineering ("Under the hood").
Screenshots are real captures of the live builds, except where a caption says concept art or
placeholder art.

**Section intro**: Four original games for the browser, each designed, written and shipped by
me, from the first greybox to the deploy pipeline. Three are playable right now and the fourth
has its first level up: no download, no install, just click and play. They're also where I push
the habits I bring to client work: game rules in pure, tested TypeScript kept apart from the
rendering, content in validated data files instead of code, and CI that ships every green push.

#### Tethered Darkness — gothic horror JRPG (playable: start to finish, final art in progress)
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
  six regions down (fens, ice, peaks, chasm, lava foundry, Hollowmere gone wrong) · five endings
  from one choice at the bottom, with five hidden charms changing what it costs · keyboard,
  gamepad or touch, cloud saves in 3 slots. Don't reveal who the ferryman really is.
- **Under the hood**: TypeScript, Phaser 4, Vite, Zod-checked JSON, Ink dialogue; pure-TS battle
  engine with a seeded RNG and a headless simulator for balancing, plus a route tool that plays
  each region in story order carrying levels and gear; Symfony 8.1 API + MySQL for accounts and
  saves; GitHub Actions deploys every green push.
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
  the Red Cardinal · eight jobs, dead villagers rise with a perk · loot worth going deeper for
  (four gear tiers, gems and sockets, a trading post) · a guide for the first three days, then
  hints; mouse or phone; Gentle, Grim or Merciless.
- **Under the hood**: TypeScript, Phaser 4; fixed-tick seeded simulation on a grid with A*,
  isometric only in rendering; all content in JSON; a scripted player balances whole seasons on
  every difficulty in the test suite; layered Blender sprites in 8 directions; the village painted
  in ComfyUI over Blender blockouts; the same Symfony save API.
- **Links**: https://village-of-suffering.proprietary-data.com · images in
  `public/images/portfolio/village-of-suffering/` (concept art is SDXL, made locally, and
  captioned as such)

#### Assimilate — physics merge puzzler (playable: final art and sound to come; added 2026-10-18)
- **Hook**: Two of a kind that touch assimilate into the next thing up. It's fifteen steps from a
  heart to Nanna.
- **Pitch**: Drop things into the jar. Two of a kind that touch become one of the next thing up:
  hearts into leaves, kiwis into cats, cats into things with too many eyes, all the way up to
  Nanna. The pile only grows, and the run is over when it stays above the line for two seconds.
  / It's the merge game you know, with rot in it. Anything left a minute lights a fuse and burns
  out into a dead black block, and a black block left five minutes explodes and throws the jar
  about. You can't nurse one old stack for ever: the longer a piece sits, the more of a problem
  it becomes.
- **Features**: fifteen tiers (heart, cannabis leaves, kiwi, four cats, grotesques, the
  Assimilator, Nanna; two Nannas vanish for a bonus) · fuses and black blocks · black blocks
  explode after five minutes · combos (0.6 s, up to 3x) and merges that pop harder · one thumb.
- **Under the hood**: TypeScript, Phaser 3 for drawing and input, rules on Matter.js used
  directly in plain TypeScript; Vitest plays whole runs headless and runs replay from a seed;
  merges found by measuring after each step (Matter's polygon circles rest apart); one tuning
  file and a bot at three paces; placeholder art drawn in code as SVG into a WebP atlas; Web
  Audio synthesis; GitHub Actions deploys every green push.
- **Links**: https://assimilate.proprietary-data.com · images in
  `public/images/portfolio/assimilate/` (the cover is three portrait captures side by side; the
  tier sheet is built from the game's own placeholder masters and captioned as such)

#### Life Detected — sci-fi horror first-person shooter (in development: first level playable)
- **Hook**: A motion tracker you listen to, and corridors darker than they should be.
- **Pitch**: You hear it before you see it. The tracker sweeps once a second, and every ping
  shows movement, never walls: something is in here with you, and you can't tell where the room
  ends. Creatures give themselves away by sound first, so the audio isn't decoration. It's the
  level design. / It's built the way the best mid-90s shooters were, where every level has a job
  to do, not just an exit to find: get the keycards, destroy the nests, bring the survivors out,
  with a briefing going in and a tally on the way out. The look aims well past the era: sculpted
  creatures, scanned materials and a torch that throws real shadows, somewhere between Doom 3
  and the 2016 Doom.
- **Features**: the motion tracker (gun or tracker, never both) · objectives, not just exits
  (the first level: two keycards, sixteen sacs, the exit) · things that hatch (sacs, parasites,
  grunts that hunt and open doors) · the torch is the main light · instant to play (WebGPU with
  WebGL 2 fallback, keyboard and mouse or gamepad). Touch controls are being built: don't claim
  them until they ship.
- **Under the hood**: Three.js WebGPU renderer; pure-TS engine at a fixed 60 Hz with a seeded
  RNG, and a Vitest bot that plays the first level from briefing to tally; Zod-checked grid
  levels; A* creatures; the grunt sculpted by script on a MakeHuman body in Blender, baked and
  rigged; scanned CC0 materials as KTX2; the first level is playtested before the campaign.
- **Links**: https://life-detected.proprietary-data.com (the first level) · images in
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
