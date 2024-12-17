<?php

namespace App\Entity;

use App\Enum\RelationType;
use App\Repository\PersonToContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonToContactRepository::class)]
#[ORM\Table(name: 'person_to_contact')]
class PersonToContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'personsToContact')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank(message: "Le prénom de la personne à contacter est obligatoire.")] // Commentaire en français
    #[Assert\Length(
        max: 100,
        maxMessage: "Le prénom ne peut pas dépasser 100 caractères."
    )]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank(message: "Le nom de la personne à contacter est obligatoire.")] // Commentaire en français
    #[Assert\Length(
        max: 100,
        maxMessage: "Le nom ne peut pas dépasser 100 caractères."
    )]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Assert\Choice(
        choices: RelationType::TYPES,
        message: "La valeur sélectionnée pour la relation est invalide." // Commentaire en français
    )]
    private ?string $relation = null;

    #[ORM\Column(type: 'string', length: 15, nullable: false)]
    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")] // Commentaire en français
    #[Assert\Regex(
        pattern: "/^\+?[0-9]{9,15}$/",
        message: "Le numéro de téléphone n'est pas valide."
    )]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "L'adresse ne peut pas dépasser 255 caractères."
    )]
    private ?string $address = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isPrimaryContact = false; // Champ indiquant si c'est la personne de contact principale

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date de création est obligatoire.")] // Commentaire en français
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "La date de mise à jour est obligatoire.")] // Commentaire en français
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
        $this->isPrimaryContact = false; // Par défaut, ce n'est pas la personne principale
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(?string $relation): static
    {
        if (!in_array($relation, RelationType::TYPES, true)) {
            throw new \InvalidArgumentException('Invalid relation type provided.');
        }

        $this->relation = $relation;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function isPrimaryContact(): bool
    {
        return $this->isPrimaryContact;
    }

    public function setIsPrimaryContact(bool $isPrimaryContact): static
    {
        $this->isPrimaryContact = $isPrimaryContact;
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
