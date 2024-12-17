<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use App\Service\Menu\SectionService;
use App\Service\ThemeHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/section/menu')]
final class SectionMenuController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private EntityManagerInterface $entityManager,
        private SectionRepository $sectionRepository,
        private SectionService $sectionService,
    )
    {
        parent::__construct($theme);
    }

    #[Route(name: 'admin_section_menu_index', methods: ['GET'])]
    public function index(SectionRepository $sectionRepository): Response
    {
        return $this->render('section_menu/index.html.twig', [
            'sections' => $sectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_section_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $section = new Section();
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sectionService->initializeSectionOrder($section);

            $entityManager->persist($section);
            $entityManager->flush();

            return $this->redirectToRoute('admin_section_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('section_menu/new.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_section_menu_show', methods: ['GET'])]
    public function show(Section $section): Response
    {
        return $this->render('section_menu/show.html.twig', [
            'section' => $section,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_section_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Section $section, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_section_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('section_menu/edit.html.twig', [
            'section' => $section,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_section_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Section $section, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$section->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($section);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_section_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
