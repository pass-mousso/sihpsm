<?php

namespace App\Repository;

use App\Entity\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Section>
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    /**
     * Récupère les sections contenant des menus accessibles
     *
     * @param array $roles Liste des rôles de l'utilisateur
     * @return Section[]
     */
    public function findSectionsByRoles(array $roles): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.menus', 'm')
            ->join('m.roles', 'r')
            ->where('r.name IN (:roles)')
            ->setParameter('roles', $roles)
            ->orderBy('s.section_order', 'ASC')
            ->addOrderBy('m.order', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
