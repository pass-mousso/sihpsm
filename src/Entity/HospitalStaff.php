<?php

namespace App\Entity;

use App\Repository\HospitalStaffRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HospitalStaffRepository::class)]
class HospitalStaff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $staffCount = null;

    #[ORM\ManyToOne(inversedBy: 'hospitalStaff')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hospital $hospital = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $doctorsCount = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $nursesCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffCount(): ?int
    {
        return $this->staffCount;
    }

    public function setStaffCount(int $staffCount): static
    {
        $this->staffCount = $staffCount;

        return $this;
    }

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): static
    {
        $this->hospital = $hospital;

        return $this;
    }

    public function getDoctorsCount(): ?int
    {
        return $this->doctorsCount;
    }

    public function setDoctorsCount(int $doctorsCount): static
    {
        $this->doctorsCount = $doctorsCount;

        return $this;
    }

    public function getNursesCount(): ?int
    {
        return $this->nursesCount;
    }

    public function setNursesCount(int $nursesCount): static
    {
        $this->nursesCount = $nursesCount;

        return $this;
    }
}
