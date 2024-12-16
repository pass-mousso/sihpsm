<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\AdminRole;
use App\Form\AdminRoleType;
use App\Repository\AdminRoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/gestion/role')]
final class AdminRoleController extends DefaultLayoutController
{
    #[Route(name: 'admin_role_index', defaults: ['description' => 'Liste des rôles'], methods: ['GET'])]
    public function index(AdminRoleRepository $adminRoleRepository): Response
    {
        return $this->render('admin_role/index.html.twig', [
            'admin_roles' => $adminRoleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_role_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adminRole = new AdminRole();
        $form = $this->createForm(AdminRoleType::class, $adminRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adminRole);
            $entityManager->flush();

            return $this->redirectToRoute('admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_role/new.html.twig', [
            'admin_role' => $adminRole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_role_show', methods: ['GET'])]
    public function show(AdminRole $adminRole): Response
    {
        return $this->render('admin_role/show.html.twig', [
            'admin_role' => $adminRole,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_role_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdminRole $adminRole, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminRoleType::class, $adminRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_role/edit.html.twig', [
            'admin_role' => $adminRole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_role_delete', methods: ['POST'])]
    public function delete(Request $request, AdminRole $adminRole, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adminRole->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adminRole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_role_index', [], Response::HTTP_SEE_OTHER);
    }
}
