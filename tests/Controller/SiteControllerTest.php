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

    public function testSitemapListsPublicRoutes(): void
    {
        $client = static::createClient();
        $client->request('GET', '/sitemap.xml');

        self::assertResponseIsSuccessful();
        self::assertStringContainsString('<loc>http://localhost/</loc>', $client->getResponse()->getContent());
    }
}
