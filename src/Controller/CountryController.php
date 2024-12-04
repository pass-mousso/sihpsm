<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/parameters/country')]
final class CountryController extends DefaultLayoutController
{
    #[Route(name: 'admin_country_index', methods: ['GET'])]
    public function index(CountryRepository $countryRepository): Response
    {
        # Include vendors and javascript files for dashboard widgets
//        $this->theme->addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return $this->render('country/index.html.twig', [
            'countries' => $countryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_country_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($country);
            $entityManager->flush();

            return $this->redirectToRoute('admin_country_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('country/new.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_country_show', methods: ['GET'])]
    public function show(Country $country): Response
    {
        return $this->render('country/show.html.twig', [
            'country' => $country,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_country_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Country $country, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_country_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('country/edit.html.twig', [
            'country' => $country,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_country_delete', methods: ['POST'])]
    public function delete(Request $request, Country $country, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$country->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_country_index', [], Response::HTTP_SEE_OTHER);
    }
}
