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
