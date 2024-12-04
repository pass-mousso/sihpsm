<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 150)]
    private ?string $username = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $email_verified_at = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToOne(mappedBy: 'users', cascade: ['persist', 'remove'])]
    private ?Person $person = null;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Hospital>
     */
    #[ORM\OneToMany(targetEntity: Hospital::class, mappedBy: 'owner')]
    private Collection $hospitals;

    /**
     * @var Collection<int, UserSubscription>
     */
    #[ORM\OneToMany(targetEntity: UserSubscription::class, mappedBy: 'user_id')]
    private Collection $userSubscriptions;

    public function __construct(){
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
        $this->isVerified = false;
        $this->status = true;
        $this->hospitals = new ArrayCollection();
        $this->userSubscriptions = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function getEmailVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(?\DateTimeImmutable $email_verified_at): static
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): static
    {
        // set the owning side of the relation if necessary
        if ($person->getUsers() !== $this) {
            $person->setUsers($this);
        }

        $this->person = $person;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Hospital>
     */
    public function getHospitals(): Collection
    {
        return $this->hospitals;
    }

    public function addHospital(Hospital $hospital): static
    {
        if (!$this->hospitals->contains($hospital)) {
            $this->hospitals->add($hospital);
            $hospital->setOwner($this);
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): static
    {
        if ($this->hospitals->removeElement($hospital)) {
            // set the owning side to null (unless already changed)
            if ($hospital->getOwner() === $this) {
                $hospital->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserSubscription>
     */
    public function getUserSubscriptions(): Collection
    {
        return $this->userSubscriptions;
    }

    public function addUserSubscription(UserSubscription $userSubscription): static
    {
        if (!$this->userSubscriptions->contains($userSubscription)) {
            $this->userSubscriptions->add($userSubscription);
            $userSubscription->setUserId($this);
        }

        return $this;
    }

    public function removeUserSubscription(UserSubscription $userSubscription): static
    {
        if ($this->userSubscriptions->removeElement($userSubscription)) {
            // set the owning side to null (unless already changed)
            if ($userSubscription->getUserId() === $this) {
                $userSubscription->setUserId(null);
            }
        }

        return $this;
    }
}
