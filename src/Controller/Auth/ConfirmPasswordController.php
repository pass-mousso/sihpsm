<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmPasswordController extends AbstractController
{
    #[Route('/auth/confirm/password', name: 'app_auth_confirm_password')]
    public function index(): Response
    {
        return $this->render('auth/confirm_password/index.html.twig', [
            'controller_name' => 'ConfirmPasswordController',
        ]);
    }
}
