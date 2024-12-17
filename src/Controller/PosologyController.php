<?php

namespace App\Controller;

use App\Entity\Posology;
use App\Form\PosologyType;
use App\Repository\PosologyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/posology')]
final class PosologyController extends AbstractController
{
    #[Route(name: 'app_posology_index', methods: ['GET'])]
    public function index(PosologyRepository $posologyRepository): Response
    {
        return $this->render('posology/index.html.twig', [
            'posologies' => $posologyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_posology_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $posology = new Posology();
        $form = $this->createForm(PosologyType::class, $posology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($posology);
            $entityManager->flush();

            return $this->redirectToRoute('app_posology_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('posology/new.html.twig', [
            'posology' => $posology,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posology_show', methods: ['GET'])]
    public function show(Posology $posology): Response
    {
        return $this->render('posology/show.html.twig', [
            'posology' => $posology,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_posology_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posology $posology, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PosologyType::class, $posology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_posology_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('posology/edit.html.twig', [
            'posology' => $posology,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posology_delete', methods: ['POST'])]
    public function delete(Request $request, Posology $posology, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$posology->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($posology);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_posology_index', [], Response::HTTP_SEE_OTHER);
    }
}
