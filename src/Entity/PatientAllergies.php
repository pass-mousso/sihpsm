<?php

namespace App\Entity;

use App\Enum\AllergyType;
use App\Repository\PatientAllergiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientAllergiesRepository::class)]
#[ORM\Table(name: 'patient_allergies')]
class PatientAllergies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'allergies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'allergie est obligatoire.")] // Commentaire en français
    #[Assert\Length(
        max: 100,
        maxMessage: "Le nom de l'allergie ne peut pas dépasser 100 caractères."
    )]
    private ?string $name = null; // Nom spécifique de l'allergie (ex. : Pollen, Noix)

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    #[Assert\NotBlank(message: "Le type d'allergie est obligatoire.")]
    #[Assert\Choice(
        choices: AllergyType::TYPES,
        message: "La valeur donnée pour le type d'allergie est invalide." // Commentaire en français
    )]
    private ?string $type = null; // Type d'allergie basé sur l'Enum

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null; // Notes/observations supplémentaires sur l'allergie

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isVisible = true;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date de création est obligatoire.")]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date de mise à jour est obligatoire.")]
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        if (!in_array($type, AllergyType::TYPES, true)) {
            throw new \InvalidArgumentException('Invalid allergy type provided.');
        }

        $this->type = $type;
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
