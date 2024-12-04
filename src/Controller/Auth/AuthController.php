<?php

namespace App\Controller\Auth;

use App\Controller\Bootstrap\DefaultLayoutController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends DefaultLayoutController
{
    public function signin(AuthenticationUtils $authenticationUtils): Response
    {
        $this->theme->addJavascriptFile('js/custom/authentication/sign-in/general.js');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/pages/auth/signin.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function reset_password(): Response
    {
        $this->theme->addJavascriptFile('js/custom/authentication/reset-password/reset-password.js');

        return $this->render('pages/auth/reset-password.html.twig');
    }

    public function new_password(): Response
    {
        $this->theme->addJavascriptFile('js/custom/authentication/reset-password/new-password.js');

        return $this->render('pages/auth/new-password.html.twig');
    }
}