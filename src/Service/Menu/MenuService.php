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
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MenuService
{
    private const MENU_CONFIG_PATH = '/config/menu/menu.php';

    private array $menuConfig = [];
    private string $menuFilePath;

    public function __construct(
        private Security $security,
        private KernelInterface $kernel,
        private UrlGeneratorInterface $urlGenerator,
    ) {
        $this->menuFilePath = $kernel->getProjectDir() . self::MENU_CONFIG_PATH;
    }

    /**
     * Récupère la structure du menu pour l'utilisateur connecté.
     * @return array
     */
    public function getMenu(): array
    {
        $this->loadMenuConfig();

        $userRoles = $this->getUserRoles();
        $menuSections = [];

        foreach ($this->menuConfig['sections'] as $section) {
            $menuSections[] = $this->buildSectionForRoles($section, $userRoles);
        }

        return array_filter($menuSections); // Élimine les sections vides
    }

    /**
     * Charge la configuration du menu.
     * @throws \RuntimeException
     */
    private function loadMenuConfig(): void
    {
        if (!file_exists($this->menuFilePath)) {
            throw new \RuntimeException("Le fichier de configuration du menu est introuvable : {$this->menuFilePath}");
        }

        $this->menuConfig = include $this->menuFilePath;

        if (!isset($this->menuConfig['sections']) || !is_array($this->menuConfig['sections'])) {
            throw new \LogicException('La configuration des sections du menu est mal formée.');
        }
    }

    /**
     * Récupère les rôles de l'utilisateur connecté.
     * @return array
     * @throws \LogicException
     */
    private function getUserRoles(): array
    {
        $user = $this->security->getUser();

        if (!$user) {
            // Vérifiez si le menu doit supporter des invités
            if ($this->allowGuestAccess()) {
                return ['ROLE_GUEST'];
            }

            // Sinon, rediriger vers la page de connexion
            header('Location: ' . $this->urlGenerator->generate('signin'));
            exit;
        }

        return $user->getRoles();
    }

    private function allowGuestAccess(): bool
    {
        // Autoriser les invités s'il existe des menus publics dans votre configuration
        foreach ($this->menuConfig['sections'] as $section) {
            foreach ($section['menus'] as $menu) {
                if (in_array('ROLE_GUEST', $menu['roles'] ?? [])) {
                    return true; // Invités autorisés
                }
            }
        }

        return false; // Rediriger si aucun rôle invité n'est trouvé
    }

    /**
     * Construit une section de menu en fonction des rôles de l'utilisateur.
     * @param array $section
     * @param array $roles
     * @return array|null
     */
    private function buildSectionForRoles(array $section, array $roles): ?array
    {
        // Validez la structure minimale de la section
        if (!isset($section['title'], $section['menus']) || !is_array($section['menus'])) {
            return null;
        }

        $menus = $this->buildMenusForRoles($section['menus'], $roles);

        if (empty($menus)) {
            return null; // Si aucun menu disponible pour cette section
        }

        return [
            'title' => $section['title'],
            'icon' => $section['icon'] ?? null,
            'menus' => $menus,
        ];
    }

    /**
     * Filtre et construit les menus pour les rôles donnés.
     * @param array $menus
     * @param array $roles
     * @return array
     */
    private function buildMenusForRoles(array $menus, array $roles): array
    {
        $filteredMenus = [];

        foreach ($menus as $menu) {
            // Vérifiez si le menu a des permissions basées sur les rôles
            if (isset($menu['roles']) && !array_intersect($menu['roles'], $roles)) {
                continue; // Skip menus non accessibles à l'utilisateur
            }

            $filteredMenus[] = [
                'icon' => $menu['icon'] ?? null,
                'label' => $menu['label'],
                'route' => $menu['route'],
                'submenus' => isset($menu['submenus'])
                    ? $this->buildMenusForRoles($menu['submenus'], $roles)
                    : [],
            ];
        }

        return $filteredMenus;
    }
}