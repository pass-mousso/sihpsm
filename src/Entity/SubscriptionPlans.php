<?php

namespace App\Entity;

use App\Repository\SubscriptionPlansRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionPlansRepository::class)]
class SubscriptionPlans
{
    const TRAIL_DAYS = 7;

    const MONTH = 1;

    const YEAR = 2;

    public const PLAN_TYPE = [
        1 => 'Month',
        2 => 'Year',
    ];

    const CURRENCY_SETTING = [
      'USD' => 'USA dollar',
      'EUR' => 'Euros',
      'GBP' => 'Pounds Sterling',
      'JPY' => 'Japanese Yen',
      'CAD' => 'Canadian Dollar',
      'AUD' => 'Australian Dollar',
    ];

    const STATUS = [
        1 => 'Active',
        2 => 'Inactive',
        3 => 'Pending',
        4 => 'Suspended',
        5 => 'Expiring'
    ];

    const SMS_LIMIT = [
        self::MONTH => 1000,
        self::YEAR => 10000,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $currency = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $frequency = null;

    #[ORM\Column]
    private ?bool $is_default = null;

    #[ORM\Column]
    private ?int $trial_days = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?int $sms_limit = null;

    /**
     * @var Collection<int, Subscriptions>
     */
    #[ORM\OneToMany(targetEntity: Subscriptions::class, mappedBy: 'plan')]
    private Collection $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
        $this->is_default = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(int $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function isDefault(): ?bool
    {
        return $this->is_default;
    }

    public function setDefault(bool $is_default): static
    {
        $this->is_default = $is_default;

        return $this;
    }

    public function getTrialDays(): ?int
    {
        return $this->trial_days;
    }

    public function setTrialDays(int $trial_days): static
    {
        $this->trial_days = $trial_days;

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

    public function getSmsLimit(): ?int
    {
        return $this->sms_limit;
    }

    public function setSmsLimit(int $sms_limit): static
    {
        $this->sms_limit = $sms_limit;

        return $this;
    }

    /**
     * @return Collection<int, Subscriptions>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscriptions $subscription): static
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
            $subscription->setPlan($this);
        }

        return $this;
    }

    public function removeSubscription(Subscriptions $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getPlan() === $this) {
                $subscription->setPlan(null);
            }
        }

        return $this;
    }
}
