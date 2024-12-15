<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ORM\Table(name: 'admin_permissions')]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AdminRole $role = null;

    #[ORM\Column(length: 150)]
    private ?string $resource = null;

    #[ORM\Column(length: 100)]
    private ?string $action = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?AdminRole
    {
        return $this->role;
    }

    public function setRole(?AdminRole $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getResource(): ?string
    {
        return $this->resource;
    }

    public function setResource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }
}
