<?php

namespace App\Repository;

use App\Entity\Subscriptions;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Subscriptions>
 */
class SubscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscriptions::class);
    }

    /**
     * Récupère l'abonnement actif pour un utilisateur donné.
     *
     * @param UserInterface $user L'utilisateur pour lequel chercher un abonnement.
     *
     * @return Subscriptions|null L'abonnement actif ou null si aucun n'est trouvé.
     */
    public function findCurrentActiveSubscription(UserInterface $user): ?Subscriptions
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.status = :status')
            ->andWhere('s.owner = :owner')
            ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNull('s.endsAt'),
                    $qb->expr()->gt('s.endsAt', ':now')
                )
            )
            ->setParameters(new ArrayCollection([
                new Parameter('status', 1),
                new Parameter('owner',   $user),
                new Parameter('now', new \DateTime())
            ]))
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Vérifie si un utilisateur a un abonnement actif.
     *
     * Un abonnement est actif si :
     * - Son statut est `true`.
     * - Il n'est pas expiré (`endsAt` est soit null, soit une date future).
     *
     * @param UserInterface $user L'utilisateur à vérifier.
     *
     * @return bool `true` si un abonnement actif existe, sinon `false`.
     */
    public function hasActiveSubscription(UserInterface $user): bool
    {
        if (!$user) {
            return false;
        }

        $qb = $this->createQueryBuilder('s');
        $qb->select('COUNT(s.id)')  // On compte les abonnements actifs
            ->where('s.status = :status')
            ->andWhere('s.owner = :owner')
            ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNull('s.endsAt'),
                    $qb->expr()->gt('s.endsAt', ':now')
                )
            )
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('status', 1),
                    new Parameter('owner',   $user),
                    new Parameter('now', new \DateTime())
                ]
            ));

        // Retourne vrai si au moins un abonnement actif est trouvé
        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
}
