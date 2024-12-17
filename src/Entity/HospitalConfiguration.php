<?php

namespace App\Entity;

use App\Repository\HospitalConfigurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: HospitalConfigurationRepository::class)]
#[ORM\Table(name: 'hospital_configuration')]
class HospitalConfiguration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Hospital::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Hospital $hospital; // L'hôpital pour lequel cette configuration s'applique

    #[ORM\JoinTable(name: 'hospital_configuration_insurance')]
    #[JoinColumn(name: 'hospital_configuration_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'insurance_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Insurance::class, inversedBy: 'insurances')]
    private Collection $insurances; // Les assurances configurables pour cet hôpital


    public function __construct()
    {
        $this->insurances = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHospital(): Hospital
    {
        return $this->hospital;
    }

    public function setHospital(Hospital $hospital): self
    {
        $this->hospital = $hospital;
        return $this;
    }

    public function getInsurances(): Collection
    {
        return $this->insurances;
    }

    public function addInsurance(Insurance $insurance): self
    {
        if (!$this->insurances->contains($insurance)) {
            $this->insurances->add($insurance);
        }

        return $this;
    }

    public function removeInsurance(Insurance $insurance): self
    {
        if ($this->insurances->contains($insurance)) {
            $this->insurances->removeElement($insurance);
        }

        return $this;
    }
}
