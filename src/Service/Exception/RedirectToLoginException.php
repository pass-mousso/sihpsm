<?php

/**
 * Class RedirectToLoginException
 *
 * This service handles subscription-related checks, such as determining whether
 * a user has an active subscription and retrieving the current subscription.
 *
 * @package App\Service\Exception
 * @author Jean Mermoz Effi
 * @email jeanmermozeffi@gmail.com
 * @version 1.0
 * @created 16/12/2024
 */

namespace App\Service\Exception;

use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectToLoginException extends \Exception
{
    private RedirectResponse $response;

    public function __construct(string $url, $message = 'User must log in.', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = new RedirectResponse($url);
    }

    public function getResponse(): RedirectResponse
    {
        return $this->response;
    }
}