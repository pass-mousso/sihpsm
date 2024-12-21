<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\Hospital;
use App\Entity\HospitalConfiguration;
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
    public function index(): Response
    {
        $hospitals = $this->hospitalRepository->findAll();

        return $this->render('hospital/index.html.twig', [
            'hospitals' => $hospitals,
        ]);
    }

    #[Route('/new', name: 'admin_hospital_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->theme->addJavascriptFile('js/hospital/create-hospital-account.js');

        $currentUser = $this->getUser();
        $currentDate = new \DateTimeImmutable();
        $params = [];
        $response = [];
        $errors = [];
        $redirectRoute = 'admin_hospital_index';
        $redirectUrl = $this->redirectToRoute($redirectRoute, $params);


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
                ;

                $configHospital = new HospitalConfiguration();
                $configHospital->setHospital($hospital);

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
                ;

                // Début de la transaction
                $entityManager->beginTransaction();

                try {
                    $this->entityManager->persist($hospital);
                    $this->entityManager->persist($userHospital);
                    $this->entityManager->persist($configHospital);
                    $this->entityManager->persist($subscription);
                    $this->entityManager->flush();

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


        return $this->render('hospital/new.html.twig', [
            'hospital' => $hospital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_hospital_show', methods: ['GET'])]
    public function show(Hospital $hospital): Response
    {
        return $this->render('hospital/show.html.twig', [
            'hospital' => $hospital,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_hospital_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hospital $hospital, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HopitalType::class, $hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_hospital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hospital/edit.html.twig', [
            'hospital' => $hospital,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_hospital_delete', methods: ['POST'])]
    public function delete(Request $request, Hospital $hospital, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hospital->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hospital);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_hospital_index', [], Response::HTTP_SEE_OTHER);
    }
}
