<?php

namespace App\Entity;

use App\Repository\PatientVaccinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientVaccinRepository::class)]
#[ORM\Table(name: 'patient_vaccin')]
class PatientVaccin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'vaccins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(targetEntity: Vaccine::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vaccine $vaccine = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\NotBlank(message: "La date d’administration du vaccin est obligatoire.")]
    private ?\DateTimeInterface $dateAdministered = null; // Date d'administration du vaccin

    // Nouveau champ : date du rappel
    #[ORM\Column(type: 'date', nullable: true)]
    #[Assert\Date]
    private ?\DateTimeInterface $dateRappel = null; // Date du rappel de dose (facultatif)

    // Nouveau champ : nombre de doses
    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Positive(message: "Le nombre de la dose doit être un entier positif.")]
    private ?int $doseVaccin = null; // Indique la dose (ex. : première, deuxième, etc.)

    // Nouveau champ : lot de production du vaccin
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Assert\Length(
        max: 50,
        maxMessage: "Le numéro de lot ne peut pas dépasser 50 caractères."
    )]
    private ?string $lotVaccin = null; // Numéro du lot du vaccin administré (facultatif)

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isVisible = true;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;
        return $this;
    }

    public function getVaccine(): ?Vaccine
    {
        return $this->vaccine;
    }

    public function setVaccine(?Vaccine $vaccine): static
    {
        $this->vaccine = $vaccine;
        return $this;
    }

    public function getDateAdministered(): ?\DateTimeInterface
    {
        return $this->dateAdministered;
    }

    public function setDateAdministered(?\DateTimeInterface $dateAdministered): static
    {
        $this->dateAdministered = $dateAdministered;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;
        return $this;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    public function getDateRappel(): ?\DateTimeInterface
    {
        return $this->dateRappel;
    }

    public function setDateRappel(?\DateTimeInterface $dateRappel): static
    {
        $this->dateRappel = $dateRappel;
        return $this;
    }

    public function getDoseVaccin(): ?int
    {
        return $this->doseVaccin;
    }

    public function setDoseVaccin(?int $doseVaccin): static
    {
        if ($doseVaccin !== null && $doseVaccin <= 0) {
            throw new \InvalidArgumentException('Le numéro de dose doit être supérieur à zéro.');
        }

        $this->doseVaccin = $doseVaccin;
        return $this;
    }

    public function getLotVaccin(): ?string
    {
        return $this->lotVaccin;
    }

    public function setLotVaccin(?string $lotVaccin): static
    {
        $this->lotVaccin = $lotVaccin;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
