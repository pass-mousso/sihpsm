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
use App\Entity\Menu;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MenuACLService
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(
        private SectionRepository $sectionRepository,
//        private RedirectResponse $redirectResponse,
        private UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * Récupère les rôles de l'utilisateur connecté.
     * @return string[]
     * @throws \LogicException
     */
    private function getUserRoles(): array
    {
        $user = $this->security->getUser();

        if (!$user) {
            return [];
        }

        return $user->getRoles();
    }


    /**
     * Récupère les menus accessibles pour l'utilisateur connecté.
     * @return array
     */
    public function getAccessibleMenus(): array
    {
        $userRoles = $this->getUserRoles();

//        dd($userRoles);

        // Récupère les sections et menus en base de données
        $sections = $this->sectionRepository->findSectionsByRoles($userRoles);

        // Transformer les données pour le rendu
        return $this->formatSections($sections);
    }

    private function formatSections(array $sections): array
    {
        $menuStructure = [];
        foreach ($sections as $section) {
            $menus = [];
            foreach ($section->getMenus() as $menu) {
                $menus[] = [
                    'label' => $menu->getTitle(),
                    'route' => $menu->getUrl(),
                    'icon' => $menu->getIcon(),
                    'submenus' => array_map(
                        fn($submenu) => [
                            'label' => $submenu->getTitle(),
                            'route' => $submenu->getUrl(),
                        ],
                        $menu->getChildren()->toArray()
                    ),
                ];
            }

            $menuStructure[] = [
                'title' => $section->getTitle(),
                'icon' => $section->getIcon(),
                'menus' => $menus,
            ];
        }

        return $menuStructure;
    }
}