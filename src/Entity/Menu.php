<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ORM\Table(name: 'admin_menus')]
#[ORM\HasLifecycleCallbacks]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $title;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(name: 'menu_order', type: 'integer', nullable: true)]
    private ?int $order = null; // Permet d'ordonner les menus.

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'menus')]
    private ?Section $section = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?Menu $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['order' => 'ASC'])] // Permet de classer les sous-menus par "order".
    private Collection $children;

    #[ORM\ManyToMany(targetEntity: AdminRole::class)]
    #[ORM\JoinTable(name: 'admin_menu_roles')]
    private Collection $roles;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $icon = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Menu $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Menu $child): self
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    #[ORM\PrePersist]
    public function setDefaultOrder(): void
    {
        if ($this->order === null) {
            $orders = [];

            // Si le menu a un parent, récupère les ordres des enfants de ce parent
            if ($this->parent !== null) {
                foreach ($this->parent->getChildren() as $child) {
                    if ($child->getOrder() !== null) {
                        $orders[] = $child->getOrder();
                    }
                }
            }
            // Sinon, si le menu appartient à une section, récupère les ordres des menus de la section
            elseif ($this->section !== null) {
                foreach ($this->section->getMenus() as $menu) {
                    if ($menu->getOrder() !== null) {
                        $orders[] = $menu->getOrder();
                    }
                }
            }

            // Si des ordres existent, définit l'ordre au maximum + 1, sinon met 1 par défaut
            $this->order = !empty($orders) ? max($orders) + 1 : 1;
        }
    }
}