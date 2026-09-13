<?php

namespace App\Controller;

use App\Dto\ContactRequest;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    public function __construct(
        private readonly MailerInterface $mailer,
        #[Autowire('%env(CONTACT_EMAIL)%')]
        private readonly string $contactEmail,
    ) {
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    #[Template('contact/index.html.twig')]
    public function index(): array
    {
        return [];
    }

    #[Route('/api/contact', name: 'api_contact_submit', methods: ['POST'])]
    public function submit(#[MapRequestPayload] ContactRequest $request): JsonResponse
    {
        $email = (new Email())
            ->from($request->email)
            ->to($this->contactEmail)
            ->subject(sprintf('Portfolio contact from %s', $request->name))
            ->text($request->message);

        $this->mailer->send($email);

        return $this->json(['status' => 'sent']);
    }
}
