<?php

/**
 * Class MenuExtension
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Twig\Menu
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 14/12/2024
 */

namespace App\Twig\Menu;
use App\Service\Menu\MenuACLService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class MenuExtension extends AbstractExtension implements GlobalsInterface
{

    public function __construct(
        private MenuACLService $menuService
    )
    {}

    /**
     * Enregistre une variable globale "_menu" disponible dans tous les templates Twig.
     */
    public function getGlobals(): array
    {
        return [
            '_menu' => $this->menuService->getAccessibleMenus(),
        ];
    }
}