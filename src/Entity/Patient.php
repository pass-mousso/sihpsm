<?php

namespace App\Entity;

use App\Enum\BloodGroup;
use App\Enum\ResultatDepranocite;
use App\Enum\StatutTestDepranocite;
use App\Repository\PatientRepository;
use App\Traits\Table\TimestampTableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Patient extends Person
{
    use TimestampTableTrait;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Blank]
    #[Assert\Length(
        min: 8,
        max: 10,
        minMessage: 'The medical record number must be at least 8 characters long.',
        maxMessage: 'The medical record number must be at most 10 characters long.'
    )]
    private ?string $medicalRecordNumber = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $height = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $numberOfChildren = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $occupation = null;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    #[Assert\Choice(choices: BloodGroup::GROUPS, message: 'Invalid blood group.')]
    private ?string $bloodGroup = null;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    #[Assert\Choice(
        choices: ResultatDepranocite::VALUES,
        message: 'Invalid result for drépanocytose.'
    )]
    private ?string $resultatDepranocite = null;

    #[ORM\Column(type: 'string', length: 20, nullable: false)]
    private ?string $statutTestDepranocite = null;

    #[ORM\OneToMany(targetEntity: PatientAffections::class, mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private Collection $affections;

    #[ORM\OneToMany(targetEntity: PersonToContact::class, mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private Collection $personsToContact;

    #[ORM\OneToMany(
        targetEntity: PatientAllergies::class,
        mappedBy: 'patient',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $allergies;

    #[ORM\OneToMany(
        targetEntity: PatientVaccin::class,
        mappedBy: 'patient',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $vaccins;

    #[ORM\OneToMany(
        targetEntity: PatientTraitement::class,
        mappedBy: "patient",
        cascade: ["persist", "remove"],
        orphanRemoval: true
    )]
    private Collection $traitements;

    #[ORM\OneToMany(targetEntity: PatientInsurance::class, mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private Collection $insurances; // Liste des assurances du patient

    #[ORM\ManyToMany(targetEntity: Hospital::class, inversedBy: 'patients')]
    #[ORM\JoinTable(
        name: 'hospital_patient',
        joinColumns: [new ORM\JoinColumn(name: 'patient_id', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'hospital_id', referencedColumnName: 'id')]
    )]
    private Collection $hospitals; // Liste des hôpitaux associés au patient

    /**
     * Le carnet médical associé à ce patient.
     */
    #[ORM\OneToOne(targetEntity: MedicalRecord::class, mappedBy: 'patient', cascade: ['persist', 'remove'])]
    private ?MedicalRecord $medicalRecord = null;

    public function __construct()
    {
        $this->affections = new ArrayCollection();
        $this->personsToContact = new ArrayCollection();
        $this->allergies = new ArrayCollection();
        $this->vaccins = new ArrayCollection();
        $this->traitements = new ArrayCollection();
        $this->insurances = new ArrayCollection();
        $this->hospitals = new ArrayCollection();
        $this->registrationDate = new \DateTime();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

    public function getMedicalRecordNumber(): ?string
    {
        return $this->medicalRecordNumber;
    }

    public function setMedicalRecordNumber(string $medicalRecordNumber): static
    {
        $this->medicalRecordNumber = $medicalRecordNumber;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getNumberOfChildren(): ?int
    {
        return $this->numberOfChildren;
    }

    public function setNumberOfChildren(?int $numberOfChildren): static
    {
        $this->numberOfChildren = $numberOfChildren;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): static
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(string $bloodGroup): static
    {
        if (!in_array($bloodGroup, BloodGroup::GROUPS, true)) {
            throw new \InvalidArgumentException('Invalid blood group.');
        }

        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function getResultatDepranocite(): ?string
    {
        return $this->resultatDepranocite;
    }

    public function setResultatDepranocite(?string $resultatDepranocite): static
    {
        if (!in_array($resultatDepranocite, ResultatDepranocite::VALUES, true)) {
            throw new \InvalidArgumentException('Invalid result for drépanocytose.');
        }

        $this->resultatDepranocite = $resultatDepranocite;

        return $this;
    }

    public function getStatutTestDepranocite(): StatutTestDepranocite
    {
        if (null === $this->statutTestDepranocite) {
            return StatutTestDepranocite::NOT_TESTED;
        }

        return StatutTestDepranocite::from($this->statutTestDepranocite);
    }

    public function setStatutTestDepranocite(StatutTestDepranocite $statutTestDepranocite): self
    {
        $this->statutTestDepranocite = $statutTestDepranocite?->name;
        return $this;
    }

    public function getAffections(): Collection
    {
        return $this->affections;
    }

    public function addAffection(PatientAffections $affection): static
    {
        if (!$this->affections->contains($affection)) {
            $this->affections->add($affection);
            $affection->setPatient($this);
        }

        return $this;
    }

    public function removeAffection(PatientAffections $affection): static
    {
        if ($this->affections->removeElement($affection)) {
            if ($affection->getPatient() === $this) {
                $affection->setPatient(null);
            }
        }

        return $this;
    }

    public function getPersonsToContact(): Collection
    {
        return $this->personsToContact;
    }

    public function addPersonToContact(PersonToContact $personToContact): static
    {
        if (!$this->personsToContact->contains($personToContact)) {
            $this->personsToContact->add($personToContact);
            $personToContact->setPatient($this);
        }

        return $this;
    }

    public function removePersonToContact(PersonToContact $personToContact): static
    {
        if ($this->personsToContact->removeElement($personToContact)) {
            if ($personToContact->getPatient() === $this) {
                $personToContact->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PatientAllergies>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    /**
     * Ajouter une allergie au patient
     */
    public function addAllergies(PatientAllergies $allergy): static
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
            $allergy->setPatient($this); // Relie bien l'allergie à ce patient
        }

        return $this;
    }

    /**
     * Supprimer une allergie du patient
     */
    public function removeAllergies(PatientAllergies $allergy): static
    {
        if ($this->allergies->removeElement($allergy)) {
            // Si l'allergie est bien liée à ce patient, on supprime cette relation
            if ($allergy->getPatient() === $this) {
                $allergy->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PatientVaccin>
     */
    public function getVaccins(): Collection
    {
        return $this->vaccins;
    }

    public function addVaccin(PatientVaccin $vaccin): static
    {
        if (!$this->vaccins->contains($vaccin)) {
            $this->vaccins->add($vaccin);
            $vaccin->setPatient($this); // Associe ce vaccin au patient
        }

        return $this;
    }

    public function removeVaccin(PatientVaccin $vaccin): static
    {
        if ($this->vaccins->removeElement($vaccin)) {
            // Supprime la relation bidirectionnelle
            if ($vaccin->getPatient() === $this) {
                $vaccin->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PatientTraitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(PatientTraitement $traitement): static
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements->add($traitement);
            $traitement->setPatient($this);
        }

        return $this;
    }

    public function removeTraitement(PatientTraitement $traitement): static
    {
        if ($this->traitements->removeElement($traitement)) {
            // Set the owning side to null (unless already changed)
            if ($traitement->getPatient() === $this) {
                $traitement->setPatient(null);
            }
        }

        return $this;
    }

    public function getInsurances(): Collection
    {
        return $this->insurances;
    }

    public function addInsurance(PatientInsurance $insurance): self
    {
        if (!$this->insurances->contains($insurance)) {
            $this->insurances->add($insurance);
            $insurance->setPatient($this);
        }

        return $this;
    }

    public function removeInsurance(PatientInsurance $insurance): self
    {
        if ($this->insurances->contains($insurance)) {
            $this->insurances->removeElement($insurance);
            // Déconnecter correctement l'assurance du patient
            if ($insurance->getPatient() === $this) {
                $insurance->setPatient(null);
            }
        }

        return $this;
    }

    public function getHospitals(): Collection
    {
        return $this->hospitals;
    }

    public function addHospital(Hospital $hospital): self
    {
        if (!$this->hospitals->contains($hospital)) {
            $this->hospitals->add($hospital);
            $hospital->addPatient($this);
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): self
    {
        if ($this->hospitals->contains($hospital)) {
            $this->hospitals->removeElement($hospital);
            $hospital->removePatient($this);
        }

        return $this;
    }

    public function getMedicalRecord(): ?MedicalRecord
    {
        return $this->medicalRecord;
    }

    public function setMedicalRecord(MedicalRecord $medicalRecord): self
    {
        // Définir le propriétaire de l'association côté MedicalRecord.
        if ($medicalRecord->getPatient() !== $this) {
            $medicalRecord->setPatient($this);
        }

        $this->medicalRecord = $medicalRecord;

        return $this;
    }


    /**
     * Calculer l'âge du patient en fonction de sa date de naissance.
     *
     * @return int L'âge calculé en années.
     */
    public function getAge(): int
    {
        $birthDate = $this->getBirthDate();
        $today = new \DateTime();
        return $today->diff($birthDate)->y;
    }

}
