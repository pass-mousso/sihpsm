<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\SubscriptionPlans;
use App\Form\SubscriptionPlansType;
use App\Repository\SubscriptionPlansRepository;
use App\Service\ThemeHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subscription/plans')]
final class SubscriptionPlansController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private EntityManagerInterface $entityManager,
        private SubscriptionPlansRepository $subscriptionPlansRepository,
    )
    {
        parent::__construct($theme);
    }

    #[Route(name: 'admin_subscription_plans_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('subscription_plans/index.html.twig', [
            'plans' => $this->subscriptionPlansRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_subscription_plans_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $subscriptionPlan = new SubscriptionPlans();
        $form = $this->createForm(SubscriptionPlansType::class, $subscriptionPlan,[
            'action' => $this->generateUrl('admin_subscription_plans_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Assurez-vous d'initialiser la propriété $isDefault à true si c'est le premier enregistrement
            $repository = $this->entityManager->getRepository(SubscriptionPlans::class);
            $existingPlans = $repository->findAll();

            if (empty($existingPlans)) {
                $subscriptionPlan->setDefault(true);
            }

            $this->entityManager->persist($subscriptionPlan);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_subscription_plans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscription_plans/new.html.twig', [
            'subscription_plan' => $subscriptionPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscription_plans_show', methods: ['GET'])]
    public function show(SubscriptionPlans $subscriptionPlan): Response
    {
        return $this->render('subscription_plans/show.html.twig', [
            'subscription_plan' => $subscriptionPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_subscription_plans_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubscriptionPlans $subscriptionPlan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubscriptionPlansType::class, $subscriptionPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_subscription_plans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscription_plans/edit.html.twig', [
            'subscription_plan' => $subscriptionPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscription_plans_delete', methods: ['POST'])]
    public function delete(Request $request, SubscriptionPlans $subscriptionPlan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscriptionPlan->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subscriptionPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_subscription_plans_index', [], Response::HTTP_SEE_OTHER);
    }
}
