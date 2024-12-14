<?php

namespace App\Entity;

use App\Repository\SubscriptionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionsRepository::class)]
class Subscriptions
{
    const ACTIVE = 1;

    const INACTIVE = 0;

    const TYPE_FREE = 0;

    const TYPE_STRIPE = 1;

    const TYPE_PAYPAL = 2;

    const TYPE_RAZORPAY = 3;

    const TYPE_CASH = 4;

    const TYPE_PAYTM = 5;

    const TYPE_PAYSTACK = 6;

    const EXPIRED = 0;

    const NOT_EXPIRED = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hospital $tenant = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $planAmount = null;

    #[ORM\Column]
    private ?int $planFrequency = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startsAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endsAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $trialEndsAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $smsLimit = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubscriptionPlans $plan = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(name: 'owner', nullable: false)]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?Hospital
    {
        return $this->tenant;
    }

    public function setTenant(?Hospital $tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPlanAmount(): ?int
    {
        return $this->planAmount;
    }

    public function setPlanAmount(int $planAmount): static
    {
        $this->planAmount = $planAmount;

        return $this;
    }

    public function getPlanFrequency(): ?int
    {
        return $this->planFrequency;
    }

    public function setPlanFrequency(int $planFrequency): static
    {
        $this->planFrequency = $planFrequency;

        return $this;
    }

    public function getStartsAt(): ?\DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeImmutable $startsAt): static
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeImmutable $endsAt): static
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getTrialEndsAt(): ?\DateTimeImmutable
    {
        return $this->trialEndsAt;
    }

    public function setTrialEndsAt(\DateTimeImmutable $trialEndsAt): static
    {
        $this->trialEndsAt = $trialEndsAt;

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

    public function getSmsLimit(): ?string
    {
        return $this->smsLimit;
    }

    public function setSmsLimit(?string $smsLimit): static
    {
        $this->smsLimit = $smsLimit;

        return $this;
    }

    public function getPlan(): ?SubscriptionPlans
    {
        return $this->plan;
    }

    public function setPlan(?SubscriptionPlans $plan): static
    {
        $this->plan = $plan;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->owner;
    }

    public function setUserId(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
