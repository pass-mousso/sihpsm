<?php

/**
 * Class RouteService
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 15/12/2024
 */

namespace App\Service;
use Symfony\Component\Routing\RouterInterface;

class RouteService
{
    public function __construct(
        private RouterInterface $router
    ){}

    /**
     * Récupère toutes les routes de l'application avec une description.
     */
    public function getRoutesWithDescriptions(): array
    {
        $routeCollection = $this->router->getRouteCollection();

        $routes = [];
        foreach ($routeCollection as $routeName => $route) {
            // Exclure les routes commençant par "_"
            if (str_starts_with($routeName, '_')) {
                continue;
            }

            $defaults = $route->getDefaults();
            $description = $defaults['description'] ?? null; // Lecture de la description si présente

            $routes[$routeName] = $description ?? $routeName; // Ajout dans la liste
        }

        return $routes;
    }

    /**
     * Retourne la description d'une route (ajustez selon vos besoins).
     */
    private function getRouteDescription(string $routeName): array
    {
        $route = $this->router->getRouteCollection()->get($routeName);

        return $route?->getDefaults('description');
    }
}