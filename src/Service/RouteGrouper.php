<?php

/**
 * Class RouteGrouper
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service\Menu
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 15/12/2024
 */

namespace App\Service;
use Symfony\Component\Routing\RouterInterface;

class RouteGrouper
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getGroupedRoutes(): array
    {
        // Récupère toutes les routes définies
        $routeCollection = $this->router->getRouteCollection();
        $groupedRoutes = [];

        foreach ($routeCollection as $name => $route) {
            if (str_starts_with($name, '_')) {
                continue;
            }

            // Diviser le nom par "_" (par ex : admin_menu_index)
            $parts = explode('_', $name);

            // Vérifier que le tableau contient au moins deux parties
            if (count($parts) >= 2) {
                $prefix = "{$parts[0]}_{$parts[1]}";

                // Ajouter la route au tableau sous le préfixe correspondant
                if (!isset($groupedRoutes[$prefix])) {
                    $groupedRoutes[$prefix] = [];
                }

                $groupedRoutes[$prefix][] = $name;
            } else {
                // Gérer le cas où la route ne suit pas le format attendu
                $groupedRoutes['others'][] = $name;
            }
        }

        return $groupedRoutes;
    }
}