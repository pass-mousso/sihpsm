<?php

namespace App\Entity;

use App\Repository\PatientInsuranceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientInsuranceRepository::class)]
#[ORM\Table(name: 'patient_insurance')]
class PatientInsurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Patient::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Patient $patient; // Relation vers le patient auquel appartient cette assurance

    #[ORM\ManyToOne(targetEntity: Insurance::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Insurance $insurance; // Relation vers l'assurance globale

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $policyNumber; // Numéro unique de la police d'assurance

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $isActive = true; // État actif/inactif de l'assurance pour ce patient

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?float $coverageAmount; // Limite de couverture personnalisée pour ce patient

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }

    public function getInsurance(): Insurance
    {
        return $this->insurance;
    }

    public function setInsurance(Insurance $insurance): self
    {
        $this->insurance = $insurance;
        return $this;
    }

    public function getPolicyNumber(): string
    {
        return $this->policyNumber;
    }

    public function setPolicyNumber(string $policyNumber): self
    {
        $this->policyNumber = $policyNumber;
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

    public function getCoverageAmount(): ?float
    {
        return $this->coverageAmount;
    }

    public function setCoverageAmount(?float $coverageAmount): self
    {
        $this->coverageAmount = $coverageAmount;
        return $this;
    }
}
