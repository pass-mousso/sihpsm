<?php

namespace App\Entity;

use App\Repository\NurseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NurseRepository::class)]
class Nurse extends Person
{
    #[ORM\Column]
    private ?int $experienceYears = null;

    public function getExperienceYears(): ?int
    {
        return $this->experienceYears;
    }

    public function setExperienceYears(int $experienceYears): static
    {
        $this->experienceYears = $experienceYears;

        return $this;
    }
}
