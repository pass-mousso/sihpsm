<?php

namespace App\Entity;

use App\Repository\HospitalRepository;
use App\Service\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HospitalRepository::class)]
class Hospital
{
    const OWNERSHIP = [
        'Public',
        'Private',
        'Non-profit',
    ];

    const TYPE_CONTACT = [
        1 => 'emergency',
        2 => 'fax',
        3 => 'general'
    ];

    const TYPE_EMAIL = [
        1 => 'support',
        2 => 'billing',
        3 => 'technical',
        4 => 'general',
        5 => 'information'
    ];

    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'hopitals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HopitalFacility $type = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 8, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 11, scale: 8, nullable: true)]
    private ?string $longitude = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Region $region = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $foundedDate = null;

    #[ORM\Column(length: 50)]
    private ?string $registrationNumber = null;

    #[ORM\Column(length: 50)]
    private ?string $ownership = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, HospitalPhoneNumbers>
     */
    #[ORM\OneToMany(targetEntity: HospitalPhoneNumbers::class, mappedBy: 'hospital', cascade: ["persist", "remove"])]
    private Collection $hospitalPhoneNumbers;

    /**
     * @var Collection<int, HospitalEmails>
     */
    #[ORM\OneToMany(targetEntity: HospitalEmails::class, mappedBy: 'hospital', cascade: ["persist", "remove"])]
    private Collection $hospitalEmails;

    /**
     * @var Collection<int, HospitalManagers>
     */
    #[ORM\OneToMany(targetEntity: HospitalManagers::class, mappedBy: 'hospital', cascade: ["persist", "remove"])]
    private Collection $hospitalManagers;

    /**
     * @var Collection<int, HospitalStaff>
     */
    #[ORM\OneToMany(targetEntity: HospitalStaff::class, mappedBy: 'hospital', cascade: ["persist", "remove"])]
    private Collection $hospitalStaff;

    #[ORM\ManyToOne(inversedBy: 'hospitals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(length: 10)]
    private ?string $tenantIdentifier = null;

    public function __construct()
    {
        $this->hospitalPhoneNumbers = new ArrayCollection();
        $this->hospitalEmails = new ArrayCollection();
        $this->hospitalManagers = new ArrayCollection();
        $this->hospitalStaff = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?HopitalFacility
    {
        return $this->type;
    }

    public function setType(?HopitalFacility $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getFoundedDate(): ?\DateTimeInterface
    {
        return $this->foundedDate;
    }

    public function setFoundedDate(?\DateTimeInterface $foundedDate): static
    {
        $this->foundedDate = $foundedDate;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): static
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getOwnership(): ?string
    {
        return $this->ownership;
    }

    public function setOwnership(string $ownership): static
    {
        $this->ownership = $ownership;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, HospitalPhoneNumbers>
     */
    public function getHospitalPhoneNumbers(): Collection
    {
        return $this->hospitalPhoneNumbers;
    }

    public function addHospitalPhoneNumber(HospitalPhoneNumbers $hospitalPhoneNumber): static
    {
        if (!$this->hospitalPhoneNumbers->contains($hospitalPhoneNumber)) {
            $this->hospitalPhoneNumbers->add($hospitalPhoneNumber);
            $hospitalPhoneNumber->setHospital($this);
        }

        return $this;
    }

    public function removeHospitalPhoneNumber(HospitalPhoneNumbers $hospitalPhoneNumber): static
    {
        if ($this->hospitalPhoneNumbers->removeElement($hospitalPhoneNumber)) {
            // set the owning side to null (unless already changed)
            if ($hospitalPhoneNumber->getHospital() === $this) {
                $hospitalPhoneNumber->setHospital(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HospitalEmails>
     */
    public function getHospitalEmails(): Collection
    {
        return $this->hospitalEmails;
    }

    public function addHospitalEmail(HospitalEmails $hospitalEmail): static
    {
        if (!$this->hospitalEmails->contains($hospitalEmail)) {
            $this->hospitalEmails->add($hospitalEmail);
            $hospitalEmail->setHospital($this);
        }

        return $this;
    }

    public function removeHospitalEmail(HospitalEmails $hospitalEmail): static
    {
        if ($this->hospitalEmails->removeElement($hospitalEmail)) {
            // set the owning side to null (unless already changed)
            if ($hospitalEmail->getHospital() === $this) {
                $hospitalEmail->setHospital(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HospitalManagers>
     */
    public function getHospitalManagers(): Collection
    {
        return $this->hospitalManagers;
    }

    public function addHospitalManager(HospitalManagers $hospitalManager): static
    {
        if (!$this->hospitalManagers->contains($hospitalManager)) {
            $this->hospitalManagers->add($hospitalManager);
            $hospitalManager->setHospital($this);
        }

        return $this;
    }

    public function removeHospitalManager(HospitalManagers $hospitalManager): static
    {
        if ($this->hospitalManagers->removeElement($hospitalManager)) {
            // set the owning side to null (unless already changed)
            if ($hospitalManager->getHospital() === $this) {
                $hospitalManager->setHospital(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HospitalStaff>
     */
    public function getHospitalStaff(): Collection
    {
        return $this->hospitalStaff;
    }

    public function addHospitalStaff(HospitalStaff $hospitalStaff): static
    {
        if (!$this->hospitalStaff->contains($hospitalStaff)) {
            $this->hospitalStaff->add($hospitalStaff);
            $hospitalStaff->setHospital($this);
        }

        return $this;
    }

    public function removeHospitalStaff(HospitalStaff $hospitalStaff): static
    {
        if ($this->hospitalStaff->removeElement($hospitalStaff)) {
            // set the owning side to null (unless already changed)
            if ($hospitalStaff->getHospital() === $this) {
                $hospitalStaff->setHospital(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getTenantIdentifier(): ?string
    {
        return $this->tenantIdentifier;
    }

    public function setTenantIdentifier(string $tenantIdentifier): static
    {
        $this->tenantIdentifier = $tenantIdentifier;

        return $this;
    }
}
