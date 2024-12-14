<?php

/**
 * Class AjaxResponse
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Utils
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 14/12/2024
 */

namespace App\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxResponse
{
    /**
     * Génère une réponse JSON pour un succès.
     *
     * @param string $message
     * @param array $data
     * @param string|null $redirectUrl
     * @return JsonResponse
     */
    public static function success(string $message, array $data = [], ?string $redirectUrl = null): JsonResponse
    {
        return new JsonResponse([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'redirectUrl' => $redirectUrl,
        ]);
    }

    /**
     * Génère une réponse JSON pour un échec (erreurs ou défauts de validation).
     *
     * @param string $message
     * @param array $errors
     * @return JsonResponse
     */
    public static function error(string $message, array $errors = []): JsonResponse
    {
        return new JsonResponse([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ]);
    }

    /**
     * Génère une réponse JSON personnalisée.
     *
     * @param bool $status
     * @param string $message
     * @param array $data
     * @param array $errors
     * @param string|null $redirectUrl
     * @return JsonResponse
     */
    public static function custom(
        bool $status,
        string $message,
        array $data = [],
        array $errors = [],
        ?string $redirectUrl = null
    ): JsonResponse {
        return new JsonResponse([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
            'redirectUrl' => $redirectUrl,
        ]);
    }
}