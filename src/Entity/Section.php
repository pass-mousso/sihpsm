<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
#[ORM\Table(name: 'admin_menus_sections')]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[ORM\OrderBy(['section_order' => 'ASC'])]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $icon = null;

    #[ORM\OneToMany(targetEntity: Menu::class, mappedBy: 'section', cascade: ['persist', 'remove'])]
    private Collection $menus;

    #[ORM\Column(nullable: true)]
    private ?int $section_order = null;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setSection($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            if ($menu->getSection() === $this) {
                $menu->setSection(null);
            }
        }

        return $this;
    }

    public function getSectionOrder(): ?int
    {
        return $this->section_order;
    }

    public function setSectionOrder(?int $section_order): static
    {
        $this->section_order = $section_order;

        return $this;
    }
}
