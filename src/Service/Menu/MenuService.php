<?php

/**
 * Class MenuService
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
use Symfony\Bundle\SecurityBundle\Security;

class MenuService
{
    private array $menuConfig = [];

    public function __construct(
        private Security $security
    )
    {
        // Charger la configuration du menu
        if (!file_exists($menuPath = __DIR__ . '/../../config/menu/menu.php')) {
            throw new \RuntimeException("Fichier de configuration du menu introuvable : {$menuPath}");
        }
        $this->menuConfig = include $menuPath;
    }

    public function getMenu(): array
    {
        if (!isset($this->menuConfig['role_permissions'], $this->menuConfig['menus'])) {
            throw new \LogicException('La configuration du menu est mal formée.');
        }

        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException('Aucun utilisateur connecté.');
        }

        $roles = $user->getRoles();
        $menus = [];

        // Récupérer les menus en fonction des rôles de l'utilisateur
        foreach ($roles as $role) {
            if (isset($this->menuConfig['role_permissions'][$role])) {
                foreach ($this->menuConfig['role_permissions'][$role] as $menuKey) {
                    // Ajouter le menu uniquement si il n'est pas déjà dans la liste
                    if (!in_array($menuKey, array_keys($menus))) {
                        $menus[$menuKey] = $this->menuConfig['menus'][$menuKey];
                    }
                }
            }
        }

        return $menus;
    }
}