<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\Hospital;
use App\Form\HospitalType;
use App\Repository\HospitalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('admin/gestion/hospital')]
#[Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_MANAGER')")]
final class HospitalController extends DefaultLayoutController
{
    #[Route(name: 'admin_hospital_index', methods: ['GET'])]
    public function index(HospitalRepository $hospitalRepository): Response
    {
        return $this->render('hopital/index.html.twig', [
            'hospitals' => $hospitalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_hospital_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->theme->addJavascriptFile('js/hopital/create-account.js');

        $hospital = new Hospital();
        $form = $this->createForm(HospitalType::class, $hospital,[
            'action' => $this->generateUrl('admin_hospital_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $businessContact = $form->get('business_contact')->getData();
            $businessEmail = $form->get('business_email')->getData();

            dd($form->getData());

            $entityManager->persist($hopital);
            $entityManager->flush();

            return $this->redirectToRoute('admin_hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hopital/new.html.twig', [
            'hospital' => $hospital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_hopital_show', methods: ['GET'])]
    public function show(Hospital $hopital): Response
    {
        return $this->render('hopital/show.html.twig', [
            'hopital' => $hopital,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hopital_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hospital $hopital, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HopitalType::class, $hopital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hopital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hopital/edit.html.twig', [
            'hopital' => $hopital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hopital_delete', methods: ['POST'])]
    public function delete(Request $request, Hospital $hopital, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hopital->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hopital);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hopital_index', [], Response::HTTP_SEE_OTHER);
    }
}
