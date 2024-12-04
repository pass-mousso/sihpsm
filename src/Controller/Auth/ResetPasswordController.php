<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/auth/reset/password', name: 'app_auth_reset_password')]
    public function index(): Response
    {
        return $this->render('auth/reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
