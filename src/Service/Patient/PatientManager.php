<?php

/**
 * Class PatientManager
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service\Patient
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 19/12/2024
 */

namespace App\Service\Patient;
use App\Constant\Roles;
use App\Entity\Hospital;
use App\Entity\MedicalRecord;
use App\Entity\Patient;
use App\Entity\PatientAffections;
use App\Entity\PatientAllergies;
use App\Entity\PatientInsurance;
use App\Entity\PatientTraitement;
use App\Entity\PatientVaccin;
use App\Entity\PersonToContact;
use App\Entity\User;
use App\Service\UniqueIdentifierService;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientManager
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private UniqueIdentifierService $uniqueIdentifier
    )
    {}

    /**
     * Crée un nouveau patient et initialise ses données.
     *
     * @param array $data Données provenant du formulaire ou d'autres sources.
     */
    public function createPatient(array $data): Patient
    {
        $patient = new Patient();

        $patient->setMedicalRecordNumber($data['medicalRecordNumber']);

        //  Crée un carnet médical pour le patient
        if (isset($data['createMedicalRecord']) && $data['createMedicalRecord'] === true) {
            $medicalRecord = new MedicalRecord();
            $patient->setMedicalRecord($medicalRecord);
        }

        // Ajout des relations (affections, allergies, vaccinations...)
        if (!empty($data['affections'])) {
            foreach ($data['affections'] as $affection) {
                $patient->addAffection($affection);
            }
        }

        if (!empty($data['allergies'])) {
            foreach ($data['allergies'] as $allergy) {
                $patient->addAllergies($allergy);
            }
        }

        return $patient;
    }

    /**
     * Crée un utilisateur lié au Patient.
     *
     * @param string $email L'email du Patient à utiliser pour le User
     * @param string $plainPassword Le mot de passe en clair pour le User
     */
    public function createUserForPatient(string $email, string $plainPassword): User
    {
        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        $user->setRoles([Roles::ROLE_PATIENT]);

        // Encoder le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);

        return $user;
    }

    /**
     * @throws RandomException
     */
    public function createPatientMedicalRecord(): MedicalRecord
    {
        $medicalRecord = new MedicalRecord();

        // Génération d'un identifiant unique pour le carnet médical
        $medicalRecord->setUniqueIdentifier(
            $this->uniqueIdentifier->generateUniqueIdentifier(MedicalRecord::class));

        $this->entityManager->persist($medicalRecord);

        return $medicalRecord;
    }

    /**
     * Logique supplémentaire lors de l'enregistrement (exemple : associations).
     */
    public function registerRelations(Patient $patient, array $relations = []): void
    {
        foreach ($relations as $relation) {
            if ($relation instanceof PersonToContact) {
                $patient->addPersonToContact($relation);
            }
        }

        foreach ($relations as $relation) {
            if ($relation instanceof PatientAllergies) {
                $patient->addAllergies($relation);
            }
        }
        foreach ($relations as $relation) {
            if ($relation instanceof PatientAffections) {
                $patient->addAffection($relation);
            }
        }
        foreach ($relations as $relation) {
            if ($relation instanceof PatientVaccin) {
                $patient->addVaccin($relation);
            }
        }
        foreach ($relations as $relation) {
            if ($relation instanceof PatientTraitement) {
                $patient->addTraitement($relation);
            }
        }
        foreach ($relations as $relation) {
            if ($relation instanceof PatientInsurance) {
                $patient->addInsurance($relation);
            }
        }
        foreach ($relations as $relation) {
            if ($relation instanceof Hospital) {
                $patient->addHospital($relation);
            }
        }
    }

    /**
     * Sauvegarde le patient en base.
     */
    public function savePatient(Patient $patient): void
    {
        $this->entityManager->persist($patient);
        $this->entityManager->flush();
    }
}