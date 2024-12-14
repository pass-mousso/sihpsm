<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\Hospital;
use App\Entity\Subscriptions;
use App\Entity\UserHospital;
use App\Form\HospitalType;
use App\Repository\HospitalRepository;
use App\Repository\SubscriptionPlansRepository;
use App\Service\ThemeHelper;
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
    public function __construct(
        ThemeHelper $theme,
        private EntityManagerInterface $entityManager,
        private SubscriptionPlansRepository $subscriptionPlansRepository,
        private HospitalRepository $hospitalRepository,
    )
    {
        parent::__construct($theme);
    }

    #[Route(name: 'admin_hospital_index', methods: ['GET'])]
    public function index(HospitalRepository $hospitalRepository): Response
    {
        $hospitals = $hospitalRepository->findAll();

        return $this->render('hospital/index.html.twig', [
            'hospitals' => $hospitals,
        ]);
    }

    #[Route('/new', name: 'admin_hospital_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $currentDate = new \DateTimeImmutable();
        $params = [];
        $response = [];
        $errors = [];
        $redirectRoute = 'admin_hospital_index';
        $redirectUrl = $this->redirectToRoute($redirectRoute, $params);

        $this->theme->addJavascriptFile('js/hospital/create-account.js');

        $hospital = new Hospital();
        $form = $this->createForm(HospitalType::class, $hospital,[
            'action' => $this->generateUrl('admin_hospital_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }

            if ($form->isValid())
            {
                $userHospital = new UserHospital();
                $userHospital->setOwner($currentUser)
                    ->setHospital($hospital)
                    ->setLastLoginAt($currentDate)
                    ->setCreatedAt($currentDate)
                    ->setUpdatedAt($currentDate)
                ;

                $subscriptionPlan = $this->subscriptionPlansRepository->findDefaultPlan();

                if (!$subscriptionPlan) {
                    throw $this->createNotFoundException('Aucun plan par défaut trouvé.');
                }

                $trialDays = $subscriptionPlan->getTrialDays();
                $planAmount = $subscriptionPlan->getPrice();
                $planFrequency = $subscriptionPlan->getFrequency();
                $smsLimit = $subscriptionPlan->getSmsLimit();

                if ($planAmount === null || $planFrequency === null || $smsLimit === null || $trialDays === null)
                {
                    throw new \LogicException('Le plan par défaut est mal configuré.');
                }

                $endDate = ($currentDate)->add(interval: new \DateInterval("P{$trialDays}D"));

                $subscription = new Subscriptions();
                $subscription->setUserId($currentUser)
                    ->setTenant($hospital)
                    ->setPlan($subscriptionPlan)
                    ->setStatus(Subscriptions::ACTIVE)
                    ->setPlanAmount($planAmount)
                    ->setPlanFrequency($planFrequency)
                    ->setSmsLimit($smsLimit)
                    ->setStartsAt(new \DateTimeImmutable())
                    ->setEndsAt($endDate)
                    ->setTrialEndsAt($endDate)
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable())
                ;

                // Début de la transaction
                $entityManager->beginTransaction();

                try {
                    $entityManager->persist($hospital);
                    $entityManager->persist($userHospital);
                    $entityManager->persist($subscription);
                    $entityManager->flush();

                    // Validation de la transaction
                    $entityManager->commit();

                    $this->addFlash('success', 'Hôpital enregistré avec succès.');
                    $status = true;
                    $message = 'Hôpital enregistré avec succès.';
                    $response = compact('status', 'message', 'redirectUrl', 'errors');

                } catch (\Exception $e) {
                    // Annulation de la transaction en cas d'erreur
                    $entityManager->rollback();
                    $status = false;
                    $errors[] = $e->getMessage();
                    $message = 'Une erreur est survenue lors de l\'enregistrement.';
                    $response = compact('status', 'message', 'errors');
                }
            } else {
                $status = false;
                $message = 'Une erreur est survenue lors de l\'enregistrement.';
                $response = compact('status', 'message', 'errors');
            }
        }

        if ($request->isXmlHttpRequest())
        {
            return $this->json($response);
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
            'hospital' => $hopital,
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
            'hospital' => $hopital,
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
