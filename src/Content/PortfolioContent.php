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
            'name' => '[Your Name]',
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
                'url' => '#',
                'images' => [
                    'images/portfolio/warhammer/army-list.png',
                    'images/portfolio/warhammer/army-detail.png',
                    'images/portfolio/warhammer/unit-detail.png',
                ],
            ],
            [
                'slug' => 'cyoa-builder',
                'name' => 'Choose-Your-Own-Adventure Builder',
                'problem' => 'Writing a branching "choose your own adventure" gamebook by hand means tracking dozens of paragraphs, battles, and item/character state from memory — error-prone past a certain size.',
                'built' => 'A server-rendered authoring tool for building and playing branching adventures — paragraphs, battles, heroes, equipment, and magic — with full CRUD for authors and a playable runtime for readers.',
                'tech' => 'Symfony, Twig, MySQL/MariaDB. Actively maintained — recently upgraded across three major Symfony versions (6→8) and to PHP 8.4.',
                'url' => '#',
                'images' => [
                    'images/portfolio/cyoa/homepage.png',
                    'images/portfolio/cyoa/gamebooks.png',
                    'images/portfolio/cyoa/play-story.png',
                    'images/portfolio/cyoa/play-combat.png',
                ],
            ],
        ];
    }

    public function getExperience(): array
    {
        return [
            ['years' => '20XX–Present', 'role' => '[Role] at [Company]', 'impact' => '[One-line, outcome-based impact]'],
            ['years' => '20XX–20XX', 'role' => '[Role] at [Company]', 'impact' => '[One-line impact]'],
        ];
    }

    public function getSocialLinks(): array
    {
        return [
            'email' => '[your@email]',
            'linkedin' => '#',
            'github' => 'https://github.com/FeatheredFiend',
            'facebook' => '#',
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
