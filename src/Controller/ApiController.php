<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur API global
 */
#[Route('/api', name: 'api_index')]
class ApiController extends AbstractController
{
    /**
     * Liste toutes les routes API disponibles sous `/api`.
     *
     * @param RouterInterface $router
     * @return JsonResponse
     */
    #[Route('', methods: ['GET'], name: 'api_list')]
    public function listApiRoutes(RouterInterface $router): JsonResponse
    {
        $routes = [];
        foreach ($router->getRouteCollection()->all() as $name => $route) {
            if (str_starts_with($route->getPath(), '/api')) { // Filtre uniquement les routes API
                $routes[] = [
                    'name' => $name,
                    'path' => $route->getPath(),
                    'methods' => $route->getMethods(),
                ];
            }
        }

        return new JsonResponse($routes);
    }
}