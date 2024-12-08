<?php

namespace App\Entity;

use App\Repository\HopitalFacilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopitalFacilityRepository::class)]
class HopitalFacility
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Hopital>
     */
    #[ORM\OneToMany(targetEntity: Hopital::class, mappedBy: 'type')]
    private Collection $hopitals;

    public function __construct()
    {
        $this->hopitals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Hopital>
     */
    public function getHopitals(): Collection
    {
        return $this->hopitals;
    }

    public function addHopital(Hopital $hopital): static
    {
        if (!$this->hopitals->contains($hopital)) {
            $this->hopitals->add($hopital);
            $hopital->setType($this);
        }

        return $this;
    }

    public function removeHopital(Hopital $hopital): static
    {
        if ($this->hopitals->removeElement($hopital)) {
            // set the owning side to null (unless already changed)
            if ($hopital->getType() === $this) {
                $hopital->setType(null);
            }
        }

        return $this;
    }
}
