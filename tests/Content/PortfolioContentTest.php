<?php

namespace App\Tests\Content;

use App\Content\PortfolioContent;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PortfolioContentTest extends KernelTestCase
{
    public function testEveryGameImageShipsInAllThreeSizesAtItsDeclaredDimensions(): void
    {
        self::bootKernel();
        $content = static::getContainer()->get(PortfolioContent::class);
        $public = static::getContainer()->getParameter('kernel.project_dir').'/public/';

        foreach ($content->getGames() as $game) {
            self::assertNotEmpty($game['images'], $game['name'].' needs at least a cover image');

            foreach ($game['images'] as $image) {
                self::assertFileExists($public.$image['path']);
                self::assertFileExists($public.str_replace('.png', '.webp', $image['path']));
                self::assertFileExists($public.str_replace('.png', '-full.webp', $image['path']));
                self::assertNotEmpty($image['caption'], $image['path'].' needs a caption');

                // The width/height attributes reserve the space before the image loads.
                [$width, $height] = getimagesize($public.$image['path']);
                self::assertSame([$image['width'], $image['height']], [$width, $height], $image['path'].' has the wrong declared size');
            }
        }
    }

    public function testEveryGameStatusIsOneTheTemplatesKnow(): void
    {
        self::bootKernel();
        $content = static::getContainer()->get(PortfolioContent::class);

        foreach ($content->getGames() as $game) {
            self::assertContains($game['status'], ['playable', 'in-development'], $game['name']);
        }
    }
}
