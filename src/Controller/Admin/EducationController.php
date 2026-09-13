<?php

namespace App\Controller\Admin;

use App\Entity\EducationCourse;
use App\Entity\EducationEntry;
use App\Form\EducationCourseType;
use App\Form\EducationEntryType;
use App\Repository\EducationEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/education')]
class EducationController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('', name: 'admin_education_index', methods: ['GET'])]
    #[Template('admin/education/index.html.twig')]
    public function index(EducationEntryRepository $repository): array
    {
        return ['entries' => $repository->findAllOrdered()];
    }

    #[Route('/new', name: 'admin_education_new', methods: ['GET', 'POST'])]
    #[Template('admin/education/form.html.twig')]
    public function new(Request $request): array|RedirectResponse
    {
        $entry = new EducationEntry();
        $form = $this->createForm(EducationEntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($entry);
            $this->entityManager->flush();
            $this->addFlash('success', 'Education entry created.');

            return $this->redirectToRoute('admin_education_index');
        }

        return ['form' => $form, 'entry' => $entry];
    }

    #[Route('/{id}/edit', name: 'admin_education_edit', methods: ['GET', 'POST'])]
    #[Template('admin/education/form.html.twig')]
    public function edit(EducationEntry $entry, Request $request): array|RedirectResponse
    {
        $form = $this->createForm(EducationEntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Education entry updated.');

            return $this->redirectToRoute('admin_education_index');
        }

        return ['form' => $form, 'entry' => $entry];
    }

    #[Route('/{id}/delete', name: 'admin_education_delete', methods: ['POST'])]
    public function delete(EducationEntry $entry, Request $request): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete-education-'.$entry->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($entry);
            $this->entityManager->flush();
            $this->addFlash('success', 'Education entry deleted.');
        }

        return $this->redirectToRoute('admin_education_index');
    }

    #[Route('/{id}/courses', name: 'admin_education_courses', methods: ['GET'])]
    #[Template('admin/education/courses.html.twig')]
    public function courses(EducationEntry $entry): array
    {
        return ['entry' => $entry];
    }

    #[Route('/{id}/courses/new', name: 'admin_education_course_new', methods: ['GET', 'POST'])]
    #[Template('admin/education/course_form.html.twig')]
    public function newCourse(EducationEntry $entry, Request $request): array|RedirectResponse
    {
        $course = new EducationCourse();
        $entry->addCourse($course);
        $form = $this->createForm(EducationCourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($course);
            $this->entityManager->flush();
            $this->addFlash('success', 'Course added.');

            return $this->redirectToRoute('admin_education_courses', ['id' => $entry->getId()]);
        }

        return ['form' => $form, 'entry' => $entry];
    }

    #[Route('/courses/{id}/edit', name: 'admin_education_course_edit', methods: ['GET', 'POST'])]
    #[Template('admin/education/course_form.html.twig')]
    public function editCourse(EducationCourse $course, Request $request): array|RedirectResponse
    {
        $entry = $course->getEducationEntry();
        $form = $this->createForm(EducationCourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Course updated.');

            return $this->redirectToRoute('admin_education_courses', ['id' => $entry->getId()]);
        }

        return ['form' => $form, 'entry' => $entry];
    }

    #[Route('/courses/{id}/delete', name: 'admin_education_course_delete', methods: ['POST'])]
    public function deleteCourse(EducationCourse $course, Request $request): RedirectResponse
    {
        $entry = $course->getEducationEntry();

        if ($this->isCsrfTokenValid('delete-course-'.$course->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($course);
            $this->entityManager->flush();
            $this->addFlash('success', 'Course deleted.');
        }

        return $this->redirectToRoute('admin_education_courses', ['id' => $entry->getId()]);
    }
}
