<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    private const PUBLIC_ROUTES = [
        'app_home',
        'app_services',
        'app_tech_stack',
        'app_projects',
        'app_experience',
        'app_contact',
    ];

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/sitemap.xml', name: 'app_sitemap', methods: ['GET'])]
    public function __invoke(): Response
    {
        $urls = array_map(
            fn (string $route) => $this->urlGenerator->generate($route, [], UrlGeneratorInterface::ABSOLUTE_URL),
            self::PUBLIC_ROUTES,
        );

        $response = $this->render('sitemap.xml.twig', ['urls' => $urls]);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
}
