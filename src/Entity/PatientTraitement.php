<?php

namespace App\Entity;

use App\Repository\PatientTraitementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientTraitementRepository::class)]
#[ORM\Table(name: "patient_traitement")]
class PatientTraitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: "traitements")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\Column(type: "string", length: 150, nullable: false)]
    #[Assert\NotBlank(message: "Le nom du traitement est obligatoire.")]
    private ?string $name = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $description = null; // Description ou remarques sur le traitement

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $posology = null; // Posologie (exemple : "3 fois par jour")

    #[ORM\Column(type: "integer", nullable: true)]
    #[Assert\Positive(message: "La durée doit être un nombre positif.")]
    private ?int $duration = null; // Durée en jours

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $startDate = null; // Date de début du traitement

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $endDate = null; // Date de fin du traitement

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $additionalInstructions = null; // Instructions supplémentaires

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isVisible = true;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: "datetime")]
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPosology(): ?string
    {
        return $this->posology;
    }

    public function setPosology(?string $posology): static
    {
        $this->posology = $posology;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAdditionalInstructions(): ?string
    {
        return $this->additionalInstructions;
    }

    public function setAdditionalInstructions(?string $additionalInstructions): static
    {
        $this->additionalInstructions = $additionalInstructions;

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
}
