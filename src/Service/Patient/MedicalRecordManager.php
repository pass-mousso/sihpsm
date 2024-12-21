<?php

/**
 * Class MedicalRecordManager
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
use App\Entity\MedicalRecord;
use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;

class MedicalRecordManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Crée un carnet médical pour un patient donné.
     *
     * @param Patient $patient Le patient auquel le carnet médical est lié.
     * @param array $data Données optionnelles à associer au carnet.
     * @return MedicalRecord Le carnet médical créé.
     */
    public function createMedicalRecord(Patient $patient, array $data = []): MedicalRecord
    {
        // Créer une instance de MedicalRecord
        $medicalRecord = new MedicalRecord();

        // Associer le patient
        $medicalRecord->setPatient($patient);

        if (isset($data['notes'])) {
            $medicalRecord->setUniqueIdentifier($data['notes']);
        }

        // Sauvegarder en base
        $this->entityManager->persist($medicalRecord);
        $this->entityManager->flush();

        return $medicalRecord;
    }

    /**
     * Récupère un carnet médical par son identifiant (ID).
     *
     * @param int $id Identifiant du carnet médical.
     * @return MedicalRecord|null Le carnet médical ou null s'il n'existe pas.
     */
    public function getMedicalRecordById(int $id): ?MedicalRecord
    {
        return $this->entityManager->getRepository(MedicalRecord::class)->find($id);
    }

    /**
     * Récupère le carnet médical lié à un patient.
     *
     * @param Patient $patient Le patient.
     * @return MedicalRecord|null Le carnet médical ou null s'il n'existe pas.
     */
    public function getMedicalRecordByPatient(Patient $patient): ?MedicalRecord
    {
        return $this->entityManager->getRepository(MedicalRecord::class)->findOneBy(['patient' => $patient]);
    }

    /**
     * Met à jour un carnet médical avec de nouvelles données.
     *
     * @param MedicalRecord $medicalRecord Le carnet médical à mettre à jour.
     * @param array $data Données à modifier.
     */
    public function updateMedicalRecord(MedicalRecord $medicalRecord, array $data): void
    {
        if (isset($data['notes'])) {
            $medicalRecord->setUniqueIdentifier($data['notes']);
        }

        // Persister les modifications
        $this->entityManager->flush();
    }

    /**
     * Supprime un carnet médical existant.
     *
     * @param MedicalRecord $medicalRecord Le carnet médical à supprimer.
     */
    public function deleteMedicalRecord(MedicalRecord $medicalRecord): void
    {
        $this->entityManager->remove($medicalRecord);
        $this->entityManager->flush();
    }

}