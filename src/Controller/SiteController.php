<?php

namespace App\Controller;

use App\Content\PortfolioContent;
use App\Repository\EducationEntryRepository;
use App\Repository\EmploymentEntryRepository;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SiteController extends AbstractController
{
    public function __construct(
        private readonly PortfolioContent $content,
    ) {
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    #[Template('home/index.html.twig')]
    public function home(): array
    {
        return [
            'hero' => $this->content->getHero(),
            'services' => $this->content->getServices(),
        ];
    }

    #[Route('/services', name: 'app_services', methods: ['GET'])]
    #[Template('page/services.html.twig')]
    public function services(): array
    {
        return [
            'services' => $this->content->getServices(),
            'howIWork' => $this->content->getHowIWork(),
        ];
    }

    #[Route('/tech-stack', name: 'app_tech_stack', methods: ['GET'])]
    #[Template('page/tech_stack.html.twig')]
    public function techStack(): array
    {
        return [
            'techStack' => $this->content->getTechStack(),
        ];
    }

    #[Route('/projects', name: 'app_projects', methods: ['GET'])]
    #[Template('projects/index.html.twig')]
    public function projects(): array
    {
        return [
            'projects' => $this->content->getProjects(),
        ];
    }

    #[Route('/experience', name: 'app_experience', methods: ['GET'])]
    #[Template('page/experience.html.twig')]
    public function experience(EmploymentEntryRepository $employment, EducationEntryRepository $education): array
    {
        return [
            'employment' => $employment->findAllOrdered(),
            'education' => $education->findAllOrdered(),
        ];
    }
}
