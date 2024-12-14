<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Service\EmailService;
use App\Service\ThemeHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class EmailMessageController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private EmailService $emailService,
    )
    {
        parent::__construct($theme);
    }

    #[Route('/email/message', name: 'app_email_message')]
    public function index(): Response
    {
        $to = 'jeanmermozeffi@gmail.com';
        $subject = 'Test email';
        $content = '/emails/user_security_email.html.twig';
        $securityData = [
            'userEmail' => 'jeanmermozeffi@gmail.com',
            'password' => 'skndkkfkkk',
        ];

        $this->emailService->sendSimpleEmail(to: $to, subject: $subject, content: $content, data: $securityData);

        return $this->render('email_message/index.html.twig', [
            'controller_name' => 'EmailMessageController',
        ]);
    }
}
