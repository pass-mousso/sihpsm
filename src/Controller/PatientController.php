<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use App\Service\Patient\PatientManager;
use App\Service\ThemeHelper;
use App\Service\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/gestion/patient')]
final class PatientController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private PatientManager $patientManager,
        private EntityManagerInterface $entityManager,
        private PatientRepository $patientRepository,
        private Utils $utils
    )
    {
        parent::__construct($theme);
    }

    #[Route(name: 'admin_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response
    {
        $this->theme->addJavascriptFile('js/admin/patient/list/list.js');

        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }

    /**
     * @throws RandomException
     */
    #[Route('/new', name: 'admin_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->theme->addJavascriptFile('js/api/location.js');

        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient, [
            'action' => $this->generateUrl('admin_patient_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email =$form->get('email')->getData();
            $password = $this->utils->generateUniqueId(type: 'password');

            $user = $this->patientManager->createUserForPatient($email, $password);
            $medicalRecord = $this->patientManager->createPatientMedicalRecord();
            $patient->setUsers($user)
                ->setMedicalRecord($medicalRecord)
                ->setMedicalRecordNumber($medicalRecord->getUniqueIdentifier());

            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('admin_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'admin_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_patient_index', [], Response::HTTP_SEE_OTHER);
    }
}
