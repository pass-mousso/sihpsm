<?php

namespace App\Entity;

use App\Repository\InsuranceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InsuranceRepository::class)]
#[ORM\Table(name: 'insurance')]
class Insurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name; // Nom de l'assurance

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $reimbursementLimit; // Plafond de remboursement (optionnel)

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isActive = true; // Indique si l'assurance est active pour cet hôpital

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Country $country; // Le pays lié à l'assurance

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getReimbursementLimit(): ?float
    {
        return $this->reimbursementLimit;
    }

    public function setReimbursementLimit(?float $reimbursementLimit): self
    {
        $this->reimbursementLimit = $reimbursementLimit;
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

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;
        return $this;
    }
}
