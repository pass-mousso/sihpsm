<?php

namespace App\Service\Subscription;

use App\Entity\Subscriptions;
use App\Repository\HospitalRepository;
use App\Repository\SubscriptionsRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Service SubscriptionChecker
 *
 * Vérifie les abonnements actifs des utilisateurs dans le système.
 */
class SubscriptionChecker
{
    /**
     * SubscriptionChecker constructor.
     *
     * @param SubscriptionsRepository $subscriptionsRepository Le repository pour accéder aux abonnements.
     * @param Security $security Le service de sécurité pour récupérer l'utilisateur connecté.
     */
    public function __construct(
        private SubscriptionsRepository $subscriptionsRepository,
        private Security $security)
    {}

    /**
     * Vérifie si l'utilisateur connecté a un abonnement actif.
     *
     * Un abonnement actif est défini comme un abonnement avec un statut actif
     * et une date de fin non expirée.
     *
     * @return bool True si l'utilisateur a un abonnement actif, sinon False.
     */
    public function hasActiveSubscription(): bool
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        $subscription = $this->subscriptionsRepository->findCurrentActiveSubscription($user);
        $isActive = $this->subscriptionsRepository->hasActiveSubscription($user);

        return $subscription !== null && $isActive;
    }

    /**
     * Récupère l'abonnement actif de l'utilisateur connecté.
     *
     * @return Subscriptions|null L'abonnement actif ou null s'il n'existe pas.
     */
    public function getCurrentActiveSubscription(): ?Subscriptions
    {
        $user = $this->security->getUser();

        if (!$user) {
            return null;
        }

        return $this->subscriptionsRepository->findCurrentActiveSubscription($user);
    }
}