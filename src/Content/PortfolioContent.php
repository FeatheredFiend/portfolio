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
                'statusLabel' => 'Playable now: start to finish, final art in progress',
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
                    ['title' => 'Six regions down', 'body' => 'From the fens through frozen wastes, jagged peaks, a sunless chasm and a foundry of lava, then back through a portal to a Hollowmere gone wrong, and down to whatever has been ringing.'],
                    ['title' => 'Five endings', 'body' => 'At the bottom, a choice: silence the bell, or relight every lantern and choose who stays below to tend them. Each of the first five regions hides an optional dungeon with a charm, and finding all five changes what that choice costs.'],
                    ['title' => 'Plays anywhere', 'body' => 'Keyboard, gamepad or a touch D-pad on your phone, with cloud saves across three slots.'],
                ],
                'tech' => 'TypeScript, Phaser 4 and Vite, with every enemy, skill and item in JSON checked by Zod, and branching dialogue written in Ink. The battle engine is pure TypeScript with a seeded random generator and no Phaser imports, so a headless simulator can play any encounter thousands of times, and a route tool plays each region in story order, carrying levels, gear and items from fight to fight, to balance every boss against the level a player really arrives at. Accounts and cloud saves run on a small Symfony 8.1 API with MySQL, and every green push to main deploys itself through GitHub Actions.',
                'url' => 'https://tethered-darkness.proprietary-data.com',
                'cta' => 'Play Tethered Darkness',
                'images' => [
                    ['path' => 'images/portfolio/tethered-darkness/mire-widow.png', 'width' => 640, 'height' => 360, 'caption' => 'The first boss, the Mire Widow, with the party\'s turn gauges filling on the right.'],
                    ['path' => 'images/portfolio/tethered-darkness/ferryman.png', 'width' => 640, 'height' => 360, 'caption' => 'Hollowmere Marsh: the ferryman leaves the party with lamp oil and a warning.'],
                    ['path' => 'images/portfolio/tethered-darkness/crowned-furnace.png', 'width' => 640, 'height' => 360, 'caption' => 'Region 5, the Abyssal Foundry: the Crowned Furnace rises out of the magma in the Crucible.'],
                    ['path' => 'images/portfolio/tethered-darkness/drowned-church.png', 'width' => 640, 'height' => 360, 'caption' => 'The Drowned Church, a church under the church, on the way down to the end.'],
                    ['path' => 'images/portfolio/tethered-darkness/the-bell.png', 'width' => 640, 'height' => 360, 'caption' => 'The last battle: the Bell, hanging in its chains over black water.'],
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
                    ['title' => 'Loot worth going deeper for', 'body' => 'Four tiers of every weapon and armour piece at the forge, gems with rolled affixes from the deepest lairs and sockets to set them in, and a trading post that sells on credit until dawn.'],
                    ['title' => 'Teaches itself, plays anywhere', 'body' => 'A guide takes new players through their first three days a prompt at a time, then first-time hints take over. Play with a mouse, or on a phone held sideways with tap, drag, pinch and box-select, on Gentle, Grim or Merciless.'],
                ],
                'tech' => 'TypeScript and Phaser 4 over a simulation in plain TypeScript that runs on a fixed tick with a seeded random generator, so any fight can be replayed exactly. Isometric is only how it\'s drawn: the rules work on a simple grid with A* pathfinding. Bones, organs, demons, gear and difficulty all live in JSON, and a scripted player plays whole seasons on every difficulty inside the test suite to check the balance. The art pipeline renders characters from 3D models in Blender as separate layers (bones, flesh, armour, weapons) in eight directions and stacks them at runtime, the way Diablo II did, while the village itself is painted in ComfyUI over Blender blockouts. Saves use the same Symfony API as Tethered Darkness.',
                'url' => 'https://village-of-suffering.proprietary-data.com',
                'cta' => 'Play The Village of Suffering',
                'images' => [
                    ['path' => 'images/portfolio/village-of-suffering/concept-art.png', 'width' => 640, 'height' => 322, 'caption' => 'Concept art, made locally with SDXL: the army, the demons, the plague doctor, the Red Cardinal, a necromancer and the graveyard.'],
                    ['path' => 'images/portfolio/village-of-suffering/send-down.png', 'width' => 640, 'height' => 360, 'caption' => 'The playable build: fitting the first army with a lantern before sending it below, on the newly painted graveyard.'],
                    ['path' => 'images/portfolio/village-of-suffering/night-graveyard.png', 'width' => 640, 'height' => 360, 'caption' => 'Night one: gravediggers at work by lantern light, with the first skeletons standing by.'],
                    ['path' => 'images/portfolio/village-of-suffering/dawn-jobs.png', 'width' => 640, 'height' => 360, 'caption' => 'Dawn of day one: who digs, who fetches the dead, who works the forge and who trades.'],
                    ['path' => 'images/portfolio/village-of-suffering/skeleton-layers.png', 'width' => 640, 'height' => 240, 'caption' => 'The Blender sprite test: one skeleton in eight directions, with armour and weapons swapped in as layers.'],
                ],
            ],
            [
                'slug' => 'assimilate',
                'name' => 'Assimilate',
                'genre' => 'Physics merge puzzler',
                'status' => 'playable',
                'statusLabel' => 'Playable now: final art and sound to come',
                'hook' => 'Two of a kind that touch assimilate into the next thing up. It\'s fifteen steps from a heart to Nanna.',
                'pitch' => [
                    'Drop things into the jar. Two of a kind that touch become one of the next thing up: hearts into leaves, kiwis into cats, cats into things with too many eyes, all the way up to Nanna. The pile only grows, and the run is over when it stays above the line for two seconds.',
                    'It\'s the merge game you know, with rot in it. Anything left a minute lights a fuse and burns out into a dead black block, and a black block left five minutes explodes and throws the jar about. You can\'t nurse one old stack for ever: the longer a piece sits, the more of a problem it becomes.',
                ],
                'features' => [
                    ['title' => 'Fifteen tiers', 'body' => 'A heart, cannabis leaves, a kiwi, four breeds of cat and some grotesques, up through the Assimilator to Nanna. Merge two Nannas and both vanish for a bonus.'],
                    ['title' => 'Fuses and black blocks', 'body' => 'Pieces age from the moment they land. Merge one before its fuse runs out or it dies as a black block, which only merges with another of its kind to come back to life.'],
                    ['title' => 'Explosions', 'body' => 'A black block left five minutes goes off, scoring nothing and throwing everything near it outward, sometimes over the line.'],
                    ['title' => 'Chains that pop', 'body' => 'Each merge within 0.6 seconds of the last builds a combo worth up to three times the points, and bigger merges pop harder, shoving the pile into a new shape.'],
                    ['title' => 'One thumb', 'body' => 'A portrait game made for phones: aim and drop with a thumb, a mouse or the keys.'],
                ],
                'tech' => 'TypeScript and Phaser 3 for drawing, input and scaling, over a rules engine in plain TypeScript on Matter.js, used directly rather than through Phaser\'s plugin, so Vitest plays whole runs headless and any run replays from its seed. Merges are found by measuring after each physics step instead of waiting for collision events, because Matter\'s circles are polygons that can rest a pixel apart while looking touching. Every tuning value lives in one file, with a bot playing seeded runs at three paces to tune it. The placeholder art is fifteen subjects drawn in code as SVG and packed into a WebP atlas, the sound and music are synthesised with Web Audio, and every green push deploys itself.',
                'url' => 'https://assimilate.proprietary-data.com',
                'cta' => 'Play Assimilate',
                'images' => [
                    ['path' => 'images/portfolio/assimilate/a-run.png', 'width' => 640, 'height' => 360, 'caption' => 'Three moments on the live build: aiming at a match, two Tentacles assimilating into a Siamese, and the jar overflowing.'],
                    ['path' => 'images/portfolio/assimilate/black-blocks.png', 'width' => 640, 'height' => 360, 'caption' => 'The Siamese\'s fuse is nearly out (the red arc), and the pieces around it have already died as black blocks, each with five minutes on its clock.'],
                    ['path' => 'images/portfolio/assimilate/fifteen-tiers.png', 'width' => 640, 'height' => 424, 'caption' => 'All fifteen tiers, from a heart to Nanna: placeholder art drawn in code, each subject on a disc of its own colour so it still reads at 28 pixels.'],
                ],
            ],
            [
                'slug' => 'life-detected',
                'name' => 'Life Detected',
                'genre' => 'Sci-fi horror first-person shooter',
                'status' => 'in-development',
                'statusLabel' => 'In development: the first level is playable',
                'hook' => 'A motion tracker you listen to, and corridors darker than they should be.',
                'pitch' => [
                    'You hear it before you see it. The tracker sweeps once a second, and every ping shows movement, never walls: something is in here with you, and you can\'t tell where the room ends. Creatures give themselves away by sound first, so the audio isn\'t decoration. It\'s the level design.',
                    'It\'s built the way the best mid-90s shooters were, where every level has a job to do, not just an exit to find: get the keycards, destroy the nests, bring the survivors out, with a briefing going in and a tally on the way out. The look aims well past the era: sculpted creatures, scanned materials and a torch that throws real shadows, somewhere between Doom 3 and the 2016 Doom.',
                ],
                'features' => [
                    ['title' => 'The motion tracker', 'body' => 'A sweep and a ping every second, with blips fading between sweeps, so you\'re always acting on a picture that\'s already out of date. Hold it up and the gun goes away.'],
                    ['title' => 'Objectives, not just exits', 'body' => 'Two to four objectives per level, with progress you can check mid-mission. The first wants two keycards found and sixteen sacs destroyed before the exit lets you leave.'],
                    ['title' => 'Things that hatch', 'body' => 'Sacs rooted into the floor open as you come near and hatch a parasite that leaps for you. Grunts, flayed miners, hunt you through the corridors and open doors.'],
                    ['title' => 'Your torch is the main light', 'body' => 'A shadow-casting flashlight, fog and glow over corridors that are dark on purpose.'],
                    ['title' => 'Instant to play', 'body' => 'Runs in the browser on WebGPU where it\'s available and WebGL 2 everywhere else, with keyboard and mouse or a gamepad.'],
                ],
                'tech' => 'Three.js with its WebGPU renderer and automatic WebGL 2 fallback, over a pure TypeScript engine stepping at a fixed 60 Hz with a seeded random generator, so a Vitest bot plays the first level from briefing to tally with no browser at all. Hand-built grid levels in JSON checked by Zod, and grid collision and A* for the creatures. The grunt is sculpted by script on a MakeHuman body in Blender, baked onto a game mesh with normal maps and rigged; the walls and floors are scanned CC0 materials packed as KTX2. The first level goes in front of playtesters before the campaign gets built.',
                'url' => 'https://life-detected.proprietary-data.com',
                'cta' => 'Play the first level',
                'images' => [
                    ['path' => 'images/portfolio/life-detected/grunt-lunges.png', 'width' => 640, 'height' => 360, 'caption' => 'The grunt, remade: a flayed miner sculpted on a MakeHuman body, lunging out of the dark.'],
                    ['path' => 'images/portfolio/life-detected/north-lamp.png', 'width' => 640, 'height' => 360, 'caption' => 'A grunt waiting under a ceiling lamp in the derelict lab.'],
                    ['path' => 'images/portfolio/life-detected/tracker.png', 'width' => 640, 'height' => 360, 'caption' => 'Tracker up, gun away: the blip is a metre off, and the screen is already red.'],
                    ['path' => 'images/portfolio/life-detected/briefing.png', 'width' => 640, 'height' => 360, 'caption' => 'The briefing: two keycards, sixteen sacs, then the exit.'],
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
