<?php

namespace App\Entity;

use App\Enum\FrequencyType;
use App\Enum\PeriodTypeEnum;
use App\Enum\UnitTypeEnum;
use App\Repository\PosologyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PosologyRepository::class)]
class Posology
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Choice(callback: [FrequencyType::class, 'cases'], message: "Sélection invalide pour la fréquence.")]
    private FrequencyType $frequencyType;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $dose = null; // Dose à chaque administration

    #[ORM\Column(type: 'string', length: 50)]
    private UnitTypeEnum $unitType;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?PeriodTypeEnum $periodType = null; // Moment de la journée (ex. : matin, midi, soir)

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $duration = null; // Durée en jours du traitement

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * FrequencyType getter and setter
     */
    public function getFrequencyType(): FrequencyType
    {
        return $this->frequencyType;
    }

    public function setFrequencyType(FrequencyType $frequencyType): static
    {
        $this->frequencyType = $frequencyType;

        return $this;
    }

    public function getDose(): ?float
    {
        return $this->dose;
    }

    public function setDose(?float $dose): static
    {
        $this->dose = $dose;

        return $this;
    }

    /**
     * UnitTypeEnum getter and setter
     */
    public function getUnitType(): UnitTypeEnum
    {
        return $this->unitType;
    }

    public function setUnitType(UnitTypeEnum $unitType): static
    {
        $this->unitType = $unitType;

        return $this;
    }

    /**
     * PeriodTypeEnum getter and setter
     */
    public function getPeriodType(): ?PeriodTypeEnum
    {
        return $this->periodType;
    }

    public function setPeriodType(?PeriodTypeEnum $periodType): static
    {
        $this->periodType = $periodType;

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
}
