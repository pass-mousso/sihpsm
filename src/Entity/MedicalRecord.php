<?php

namespace App\Entity;

use App\Repository\MedicalRecordRepository;
use App\Traits\Table\TimestampTableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalRecordRepository::class)]
class MedicalRecord
{
    use TimestampTableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * L'identifiant unique du carnet médical.
     */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $uniqueIdentifier = null;

    /**
     * Statut du carnet médical : actif ou inactif.
     */
    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    /**
     * Le patient associé à ce carnet médical.
     * Relation un-à-un (OneToOne) avec l'entité Patient.
     */
    #[ORM\OneToOne(targetEntity: Patient::class, inversedBy: 'medicalRecord', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)] // Assure qu'un carnet médical ne peut pas exister sans avoir un patient
    private ?Patient $patient = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqueIdentifier(): ?string
    {
        return $this->uniqueIdentifier;
    }

    public function setUniqueIdentifier(string $uniqueIdentifier): self
    {
        $this->uniqueIdentifier = $uniqueIdentifier;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
