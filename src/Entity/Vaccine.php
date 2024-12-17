<?php

namespace App\Entity;

use App\Repository\VaccineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VaccineRepository::class)]
#[ORM\Table(name: 'vaccine')]
class Vaccine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private ?string $name = null; // Nom du vaccin

    #[ORM\ManyToOne(targetEntity: Hospital::class, inversedBy: 'vaccines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hospital $hospital = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHospital(): ?Hospital
    {
        return $this->hospital;
    }

    public function setHospital(?Hospital $hospital): static
    {
        $this->hospital = $hospital;
        return $this;
    }
}
