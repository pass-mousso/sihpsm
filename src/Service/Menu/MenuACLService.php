<?php

/**
 * Class MenuACLService
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service\Menu
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 14/12/2024
 */

namespace App\Service\Menu;
class MenuACLService
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function getMenusForCurrentUser(): array
    {
        // Obtenez l'utilisateur connecté
        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException('Aucun utilisateur connecté.');
        }

        // Récupérez les rôles de l'utilisateur
        $roles = $user->getRoles();

        // Récupérer les menus principaux (ceux sans parent) pour les rôles donnés
        $menuRepository = $this->entityManager->getRepository(Menu::class);

        $query = $menuRepository->createQueryBuilder('m')
            ->leftJoin('m.roles', 'r')
            ->leftJoin('m.children', 'c')
            ->where('r.name IN (:roles)')
            ->andWhere('m.parent IS NULL') // Seulement les menus principaux
            ->setParameter('roles', $roles)
            ->orderBy('m.order', 'ASC')
            ->getQuery();

        $menus = $query->getResult();

        // Formatez les menus en tableau pour retourner une structure hiérarchique
        return $this->formatMenus($menus);
    }

    private function formatMenus(array $menus): array
    {
        $result = [];
        foreach ($menus as $menu) {
            $result[] = [
                'title' => $menu->getTitle(),
                'url' => $menu->getUrl(),
                'children' => $this->formatMenus($menu->getChildren()->toArray()), // Récuperer les sous-menus
            ];
        }

        return $result;
    }
}