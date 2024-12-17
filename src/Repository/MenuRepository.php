<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    /**
     * Récupère les menus par rôle utilisateur
     *
     * @param array $roles Liste des rôles de l'utilisateur
     * @return Menu[]
     */
    public function findMenusByRoles(array $roles): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.roles', 'r')
            ->where('r.name IN (:roles)')
            ->setParameter('roles', $roles)
            ->orderBy('m.order', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findMenusWithoutSection()
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.section IS NULL') // Exclure les menus attribués à une section
            ->getQuery()
            ->getResult();
    }
}
