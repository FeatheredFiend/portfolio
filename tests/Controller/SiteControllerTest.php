<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SiteControllerTest extends WebTestCase
{
    #[DataProvider('publicPageProvider')]
    public function testPublicPageIsSuccessful(string $path): void
    {
        $client = static::createClient();
        $client->request('GET', $path);

        self::assertResponseIsSuccessful();
    }

    public static function publicPageProvider(): iterable
    {
        yield 'home' => ['/'];
        yield 'services' => ['/services'];
        yield 'tech stack' => ['/tech-stack'];
        yield 'projects' => ['/projects'];
        yield 'experience' => ['/experience'];
        yield 'contact' => ['/contact'];
    }

    public function testHomePageLinksToProjects(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('a[href="/projects"]');
    }

    public function testProjectsPageShowcasesTheGamesAheadOfTheWebApps(): void
    {
        $client = static::createClient();
        $client->request('GET', '/projects');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('#games h2', 'Games');
        self::assertSelectorTextContains('#tethered-darkness h3', 'Tethered Darkness');
        self::assertSelectorExists('#tethered-darkness a.button[href="https://tethered-darkness.proprietary-data.com"]');
        self::assertSelectorTextContains('#village-of-suffering h3', 'The Village of Suffering');
        self::assertSelectorExists('#village-of-suffering a.button[href="https://village-of-suffering.proprietary-data.com"]');
        self::assertSelectorTextContains('#assimilate h3', 'Assimilate');
        self::assertSelectorTextContains('#assimilate .game-card__status', 'Playable now');
        self::assertSelectorExists('#assimilate a.button--game[href="https://assimilate.proprietary-data.com"]');
        self::assertSelectorTextContains('#life-detected .game-card__status', 'In development');
        self::assertSelectorTextContains('#life-detected a.button[href="https://life-detected.proprietary-data.com"]', 'Play the first level');
        self::assertSelectorTextContains('#web-apps h2', 'Web apps');
        self::assertSelectorExists('#web-apps #miniature-collection-tracker');
        self::assertSelectorExists('#web-apps #cyoa-builder');
    }

    public function testHomePageTeasesEachGame(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
        foreach (['tethered-darkness', 'village-of-suffering', 'assimilate', 'life-detected'] as $slug) {
            self::assertSelectorExists(sprintf('.games-teaser a[href="/projects#%s"]', $slug));
        }
    }

    public function testFooterListsOnlyThePlayableGames(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertSelectorExists('.site-footer__projects a[href="https://assimilate.proprietary-data.com"]');
        self::assertSelectorNotExists('.site-footer__projects a[href="https://life-detected.proprietary-data.com"]');
    }

    public function testSitemapListsPublicRoutes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/sitemap.xml');

        self::assertResponseIsSuccessful();
        self::assertStringContainsString('<loc>http://localhost/</loc>', $client->getResponse()->getContent());
    }
}
