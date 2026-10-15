<?php

namespace App\Content;

/**
 * Hardcoded site copy, per the plan: no database until content needs to be
 * editable without a redeploy. Source text lives in content/copy.md; this is
 * where it gets wired into the pages. Bracketed placeholders are copied
 * verbatim until real values are supplied.
 */
class PortfolioContent
{
    public function getHero(): array
    {
        return [
            'name' => 'Martyn Woollard',
            'title' => 'Full-Stack Developer — PHP, Symfony & Laravel',
            'valueProp' => 'Ten years turning slow, fragile PHP apps into fast, maintainable ones — and building new tools from scratch when there isn\'t one yet.',
        ];
    }

    public function getServices(): array
    {
        return [
            [
                'problem' => 'Your PHP app still runs — barely.',
                'body' => 'Aging Symfony/Laravel codebases don\'t have to mean rewrites. I upgrade PHP and framework versions safely, one major version at a time, with real regression checks at every step — no "it works on my machine" guesswork.',
                'outcome' => 'Fewer security warnings, faster page loads, a codebase your next developer won\'t dread.',
            ],
            [
                'problem' => 'You need something built, not just discussed.',
                'body' => 'Custom internal tools, admin dashboards, or customer-facing apps — built full-stack with Symfony/Laravel on the backend and React or Angular where the UI actually needs it.',
                'outcome' => 'A working tool in weeks, not a requirements doc that never ships.',
            ],
            [
                'problem' => 'Your API falls over under real traffic.',
                'body' => 'Slow queries, N+1 problems, endpoints that were never meant to serve this much load. I profile, index, cache, and restructure until the numbers hold up.',
                'outcome' => 'APIs that scale with your product instead of becoming the bottleneck.',
            ],
            [
                'problem' => 'Nobody on the team wants to touch that codebase.',
                'body' => 'Undocumented legacy systems are a liability every time someone leaves. I do focused audits — what\'s fragile, what\'s safe to change, what should be rewritten — and leave the team with a map, not just a report.',
                'outcome' => 'Less tribal knowledge, more confidence making changes.',
            ],
        ];
    }

    public function getHowIWork(): array
    {
        return [
            ['step' => 'Discovery', 'body' => 'A short call to understand the actual problem, not just the feature request.'],
            ['step' => 'Build', 'body' => 'Regular check-ins, working software early, not a single reveal at the end.'],
            ['step' => 'Deliver', 'body' => 'Deployed, documented, and handed off cleanly, including a walkthrough so your team isn\'t stuck depending on me.'],
        ];
    }

    public function getTechStack(): array
    {
        return [
            'Backend' => ['PHP', 'Symfony', 'Laravel'],
            'Frontend' => ['React', 'Angular', 'TypeScript', 'JavaScript', 'HTML/CSS'],
            'Database' => ['MySQL', 'MariaDB'],
            'Tools' => ['Docker', 'Git/GitHub', 'Vite', 'GitHub Actions (CI/CD)'],
        ];
    }

    public function getProjects(): array
    {
        return [
            [
                'slug' => 'miniature-collection-tracker',
                'name' => 'Miniature Collection Tracker',
                'problem' => 'Tracking a growing tabletop miniature collection — armies, units, painting progress, and game history — in spreadsheets doesn\'t scale and leaves no visual record.',
                'built' => 'A full-stack tracker with user accounts, army/unit management, game logging, and photo galleries for painted miniatures.',
                'tech' => 'Symfony (API/backend), React + Vite (frontend), MySQL, deployed via GitHub Actions CI/CD.',
                'url' => 'https://warhammer.proprietary-data.com',
                'images' => [
                    ['path' => 'images/portfolio/warhammer/army-list.png', 'width' => 640, 'height' => 164],
                    ['path' => 'images/portfolio/warhammer/army-detail.png', 'width' => 640, 'height' => 398],
                    ['path' => 'images/portfolio/warhammer/unit-detail.png', 'width' => 640, 'height' => 314],
                ],
            ],
            [
                'slug' => 'cyoa-builder',
                'name' => 'Choose-Your-Own-Adventure Builder',
                'problem' => 'Writing a branching "choose your own adventure" gamebook by hand means tracking dozens of paragraphs, battles, and item/character state from memory — error-prone past a certain size.',
                'built' => 'A server-rendered authoring tool for building and playing branching adventures — paragraphs, battles, heroes, equipment, and magic — with full CRUD for authors and a playable runtime for readers.',
                'tech' => 'Symfony, Twig, MySQL/MariaDB. Actively maintained — recently upgraded across three major Symfony versions (6→8) and to PHP 8.4.',
                'url' => 'https://cyoa.proprietary-data.com',
                'images' => [
                    ['path' => 'images/portfolio/cyoa/homepage.png', 'width' => 640, 'height' => 283],
                    ['path' => 'images/portfolio/cyoa/gamebooks.png', 'width' => 640, 'height' => 67],
                    ['path' => 'images/portfolio/cyoa/play-story.png', 'width' => 640, 'height' => 271],
                    ['path' => 'images/portfolio/cyoa/play-combat.png', 'width' => 640, 'height' => 502],
                ],
            ],
        ];
    }

    /**
     * Original browser games, written to sell each concept first, with the engineering
     * underneath. Status is 'playable' or 'in-development'. The first image is the cover;
     * each image path is a 640px PNG with a .webp twin and a 1280px "-full.webp" beside it.
     */
    public function getGames(): array
    {
        return [
            [
                'slug' => 'tethered-darkness',
                'name' => 'Tethered Darkness',
                'genre' => 'Gothic horror JRPG',
                'status' => 'playable',
                'statusLabel' => 'Playable now: regions 1–4 of 6',
                'hook' => 'Every grave in Hollowmere has a lantern, and the lanterns keep the dead below. Tonight they are going out.',
                'pitch' => [
                    'A disgraced knight, an occultist and a church cantor are left on a fen jetty by a ferryman who won\'t wait. Up in Broodhollow the churchyard lanterns are dying, the dead are climbing out, and somewhere beneath the water a drowned bell screams each time another light fails. They follow the sound down.',
                    'It\'s the 16-bit Final Fantasy you grew up with, with the dial turned from adventure to dread: fog, candlelight, drowned churches, and things that move just past the edge of your lantern. The horror comes from what you can\'t see, and from what the light costs you.',
                ],
                'features' => [
                    ['title' => 'Light is a resource', 'body' => 'The floors before every boss are dark. Spend scarce lantern oil to light them, or fight in a shrinking circle of light against monsters 20% stronger.'],
                    ['title' => 'Real-time turn gauges', 'body' => 'Heroes and monsters fill their gauges in real time, so hesitating in a menu is a decision too.'],
                    ['title' => 'Learn from the dead', 'body' => 'The cantor Absorbs enemies to learn their skills and fill in the bestiary, the occultist steals, and the knight takes the hit for whoever needs it.'],
                    ['title' => 'No random battles', 'body' => 'Every enemy is on the map. Slip past the fights you don\'t want, or pick them for what they carry.'],
                    ['title' => 'Secrets worth the dark', 'body' => 'Each of the first five regions hides an optional dungeon with a charm at the bottom. Find all five and the ending changes.'],
                    ['title' => 'Plays anywhere', 'body' => 'Keyboard, gamepad or a touch D-pad on your phone, with cloud saves across three slots.'],
                ],
                'tech' => 'TypeScript, Phaser 4 and Vite, with every enemy, skill and item in JSON checked by Zod, and branching dialogue written in Ink. The battle engine is pure TypeScript with a seeded random generator and no Phaser imports, so a headless simulator can play any encounter thousands of times to balance it. Accounts and cloud saves run on a small Symfony 8.1 API with MySQL, and every green push to main deploys itself through GitHub Actions.',
                'url' => 'https://tethered-darkness.proprietary-data.com',
                'cta' => 'Play Tethered Darkness',
                'images' => [
                    ['path' => 'images/portfolio/tethered-darkness/mire-widow.png', 'width' => 640, 'height' => 360, 'caption' => 'The first boss, the Mire Widow, with the party\'s turn gauges filling on the right.'],
                    ['path' => 'images/portfolio/tethered-darkness/ferryman.png', 'width' => 640, 'height' => 360, 'caption' => 'Hollowmere Marsh: the ferryman leaves the party with lamp oil and a warning.'],
                    ['path' => 'images/portfolio/tethered-darkness/drowned-churchyard.png', 'width' => 640, 'height' => 360, 'caption' => 'The Drowned Churchyard: ghouls and a lantern-bearing ghost.'],
                    ['path' => 'images/portfolio/tethered-darkness/marsh-path.png', 'width' => 640, 'height' => 360, 'caption' => 'The marsh path at night, lit only by what the lanterns reach.'],
                    ['path' => 'images/portfolio/tethered-darkness/title-screen.png', 'width' => 640, 'height' => 360, 'caption' => 'The title screen.'],
                ],
            ],
            [
                'slug' => 'village-of-suffering',
                'name' => 'The Village of Suffering',
                'genre' => 'Grim isometric real-time strategy',
                'status' => 'playable',
                'statusLabel' => 'Playable now: the whole loop, final art in progress',
                'hook' => 'Villagers dig up the graveyard. The dead rise as skeletons. The skeletons go below to fight demons for the organs that make the next army stronger.',
                'pitch' => [
                    'Your village knows exactly what becomes of its dead, and works for you anyway. By night the gravediggers sink the graveyard one level deeper. By day you stitch what they find into skeletons, arm them at the forge, and march them down the one grave that breaks open into a fresh dungeon at dawn.',
                    'Every demon down there drops something worth stitching in: a heart for strength and speed, a brain for resistances and a better grip on a weapon. The deeper you dig, the stronger the army you can build to dig deeper still, until something on the twenty-fifth level wakes up and notices you.',
                ],
                'features' => [
                    ['title' => 'Build your army from the dead', 'body' => 'Six bones make a skeleton; up to twelve make a monster with extra skulls, arms and torsos. Organs, flesh and armour layer on top, with no fixed recipes.'],
                    ['title' => 'A new dungeon every dawn', 'body' => 'Each morning one grave breaks open into a freshly generated dungeon that closes at the next dawn. An army still below is stranded and has to dig its own way out.'],
                    ['title' => 'Bring your own light', 'body' => 'Armies below see only by their light keeper\'s torch or lantern. Lose it and your skeletons fight half-blind.'],
                    ['title' => 'Trouble from above', 'body' => 'The church next door is watching. Dig up too many of its dead and suspicion becomes a mob, while the Red Cardinal steals corpses from your ranks.'],
                    ['title' => 'Every villager counts', 'body' => 'One small pool of villagers is split across eight jobs each dawn. The dead never come back, but they rise into your army with a perk from the trade they died in.'],
                    ['title' => 'Phone-ready', 'body' => 'Play with a mouse, or on a phone held sideways with tap, drag, pinch and box-select.'],
                ],
                'tech' => 'TypeScript and Phaser 4 over a simulation in plain TypeScript that runs on a fixed tick with a seeded random generator, so any fight can be replayed exactly. Isometric is only how it\'s drawn: the rules work on a simple grid with A* pathfinding. Bones, organs, demons and difficulty all live in JSON, and a scripted player plays whole seasons inside the test suite to check the balance. The art pipeline renders characters from 3D models in Blender as separate layers (bones, flesh, armour, weapons) in eight directions and stacks them at runtime, the way Diablo II did. Saves use the same Symfony API as Tethered Darkness.',
                'url' => 'https://village-of-suffering.proprietary-data.com',
                'cta' => 'Play The Village of Suffering',
                'images' => [
                    ['path' => 'images/portfolio/village-of-suffering/concept-art.png', 'width' => 640, 'height' => 322, 'caption' => 'Concept art, made locally with SDXL: the army, the demons, the plague doctor, the Red Cardinal, a necromancer and the graveyard.'],
                    ['path' => 'images/portfolio/village-of-suffering/send-down.png', 'width' => 640, 'height' => 360, 'caption' => 'The playable build: fitting the first army with a lantern before sending it below.'],
                    ['path' => 'images/portfolio/village-of-suffering/dawn-jobs.png', 'width' => 640, 'height' => 360, 'caption' => 'Dawn of day one: who digs, who fetches the dead, who works the forge.'],
                    ['path' => 'images/portfolio/village-of-suffering/places-below.png', 'width' => 640, 'height' => 322, 'caption' => 'Concept art for the places below and around the village: caves, dungeons, catacombs, the hellish depths, the church and the forge.'],
                    ['path' => 'images/portfolio/village-of-suffering/skeleton-layers.png', 'width' => 640, 'height' => 240, 'caption' => 'The Blender sprite test: one skeleton in eight directions, with armour and weapons swapped in as layers.'],
                ],
            ],
            [
                'slug' => 'life-detected',
                'name' => 'Life Detected',
                'genre' => 'Retro-plus first-person shooter',
                'status' => 'in-development',
                'statusLabel' => 'In development: building the first level',
                'hook' => 'A motion tracker you listen to, and corridors darker than they should be.',
                'pitch' => [
                    'You hear it before you see it. The tracker sweeps once a second, and every ping shows movement, never walls: something is in here with you, and you can\'t tell where the room ends. Creatures give themselves away by sound first, so the audio isn\'t decoration. It\'s the level design.',
                    'It\'s built the way the best mid-90s shooters were, where every level has a job to do, not just an exit to find: get the keycard, destroy the nest, bring the survivors out, with a briefing going in and a tally on the way out. Low-poly models under modern lighting keep that 1996 feel, and the shadows do the frightening.',
                ],
                'features' => [
                    ['title' => 'The motion tracker', 'body' => 'A sweep and a ping every second, with blips fading between sweeps, so you\'re always acting on a picture that\'s already out of date.'],
                    ['title' => 'Objectives, not just exits', 'body' => 'Two to four objectives per level, from keycards to nests to rescues, with progress you can check mid-mission.'],
                    ['title' => 'Your torch is the main light', 'body' => 'A shadow-casting flashlight, fog and glow over corridors that are dark on purpose.'],
                    ['title' => 'Instant to play', 'body' => 'Runs in the browser with the first level under 15 MB, on WebGPU where it\'s available and WebGL 2 everywhere else.'],
                ],
                'tech' => 'Three.js with its WebGPU renderer and automatic WebGL 2 fallback, over a pure TypeScript engine stepping at a fixed 60 Hz with a seeded random generator, so Vitest can play whole levels with no browser at all. Hand-built grid levels in JSON checked by Zod, grid collision and A* for the creatures, and a scripted Blender and ComfyUI pipeline for the corridor kit and textures, compressed with meshopt and KTX2. One finished level goes in front of playtesters before the campaign gets built.',
                'url' => 'https://life-detected.proprietary-data.com',
                'cta' => 'See the holding page',
                'images' => [
                    ['path' => 'images/portfolio/life-detected/holding-page.png', 'width' => 640, 'height' => 195, 'caption' => 'The holding page, while the motion tracker is still calibrating.'],
                ],
            ],
        ];
    }

    public function getSocialLinks(): array
    {
        return [
            'email' => 'martynwoollardwebdev@gmail.com',
            'linkedin' => 'https://www.linkedin.com/in/martyn-woollard-347b8b128',
            'github' => 'https://github.com/FeatheredFiend',
            'facebook' => 'https://www.facebook.com/ProprietaryData/',
        ];
    }

    /**
     * @return list<string> real (non-placeholder) social URLs, for schema.org sameAs
     */
    public function getSameAsUrls(): array
    {
        return array_values(array_filter(
            $this->getSocialLinks(),
            static fn (string $url) => str_starts_with($url, 'http'),
        ));
    }
}
