<?php

namespace App\Entity;

use App\Repository\SubscriptionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionsRepository::class)]
class Subscriptions
{
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
    private ?int $plan_amount = null;

    #[ORM\Column]
    private ?int $plan_frequency = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $starts_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $ends_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $trial_ends_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $sms_limit = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubscriptionPlans $plan = null;

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
        return $this->plan_amount;
    }

    public function setPlanAmount(int $plan_amount): static
    {
        $this->plan_amount = $plan_amount;

        return $this;
    }

    public function getPlanFrequency(): ?int
    {
        return $this->plan_frequency;
    }

    public function setPlanFrequency(int $plan_frequency): static
    {
        $this->plan_frequency = $plan_frequency;

        return $this;
    }

    public function getStartsAt(): ?\DateTimeImmutable
    {
        return $this->starts_at;
    }

    public function setStartsAt(\DateTimeImmutable $starts_at): static
    {
        $this->starts_at = $starts_at;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeImmutable
    {
        return $this->ends_at;
    }

    public function setEndsAt(\DateTimeImmutable $ends_at): static
    {
        $this->ends_at = $ends_at;

        return $this;
    }

    public function getTrialEndsAt(): ?\DateTimeImmutable
    {
        return $this->trial_ends_at;
    }

    public function setTrialEndsAt(\DateTimeImmutable $trial_ends_at): static
    {
        $this->trial_ends_at = $trial_ends_at;

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

    public function getSmsLimit(): ?string
    {
        return $this->sms_limit;
    }

    public function setSmsLimit(?string $sms_limit): static
    {
        $this->sms_limit = $sms_limit;

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
}
