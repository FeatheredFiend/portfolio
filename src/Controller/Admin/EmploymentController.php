<?php

namespace App\Controller\Admin;

use App\Entity\EmploymentEntry;
use App\Form\EmploymentEntryType;
use App\Repository\EmploymentEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/employment')]
class EmploymentController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'admin_employment_index', methods: ['GET'])]
    #[Template('admin/employment/index.html.twig')]
    public function index(EmploymentEntryRepository $repository): array
    {
        return ['entries' => $repository->findAllOrdered()];
    }

    #[Route('/new', name: 'admin_employment_new', methods: ['GET', 'POST'])]
    #[Template('admin/employment/form.html.twig')]
    public function new(Request $request): array|RedirectResponse
    {
        $entry = new EmploymentEntry();
        $form = $this->createForm(EmploymentEntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($entry);
            $this->entityManager->flush();
            $this->addFlash('success', 'Employment entry created.');

            return $this->redirectToRoute('admin_employment_index');
        }

        return ['form' => $form, 'entry' => $entry];
    }

    #[Route('/{id}/edit', name: 'admin_employment_edit', methods: ['GET', 'POST'])]
    #[Template('admin/employment/form.html.twig')]
    public function edit(EmploymentEntry $entry, Request $request): array|RedirectResponse
    {
        $form = $this->createForm(EmploymentEntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Employment entry updated.');

            return $this->redirectToRoute('admin_employment_index');
        }

        return ['form' => $form, 'entry' => $entry];
    }

    #[Route('/{id}/delete', name: 'admin_employment_delete', methods: ['POST'])]
    public function delete(EmploymentEntry $entry, Request $request): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete-employment-'.$entry->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($entry);
            $this->entityManager->flush();
            $this->addFlash('success', 'Employment entry deleted.');
        }

        return $this->redirectToRoute('admin_employment_index');
    }
}
