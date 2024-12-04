<?php

namespace App\Controller\Auth;

use App\Constant\Roles;
use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Service\Auth\RoleService;
use App\Service\ThemeHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route("auth/")]
class RegisterController extends AbstractController
{
    public function __construct(
        public ThemeHelper $theme,
        private EmailVerifier $emailVerifier,
        private RoleService $roleService,
        private EntityManagerInterface $entityManager,
    ){
//        $this->init();
    }


    #[Route('signup', name: 'signup')]
    public function signup(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $this->theme->addJavascriptFile('js/custom/authentication/sign-up/general.js');

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user,[
            'action' => $this->generateUrl('signup'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        $data = null;

        if ($form->isSubmitted()) {
            $response = [];
            $params = [];
            $redirectRoute = 'signin';
            $redirect = $this->generateUrl($redirectRoute, $params);

            if ($form->isValid()) {
                /** @var string $plainPassword */
                $plainPassword = $form->get('plainPassword')->getData();

                // encode the plain password
                $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

                $user->setRoles([Roles::ROLE_OWNER]);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $message = 'Opération effectuée avec succès';
                $statut = 1;
                $data = true;
                $this->addFlash('success', $message);

                // generate a signed url and email it to the user
//                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                    (new TemplatedEmail())
//                        ->from(new Address('sih@passmousso.net', 'SIH'))
//                        ->to((string) $user->getEmail())
//                        ->subject('Please Confirm your Email')
//                        ->htmlTemplate('registration/confirmation_email.html.twig')
//                );
            } else {
                $statut = 0;
            }

            if ($request->isXmlHttpRequest()) {
                $response = compact('statut', 'message', 'redirect', 'data');
                return $this->json($response);
            } else {
                if ($statut == 1) {
                    return $this->redirect($redirect);
                }
            }
        }

        return $this->render('admin/pages/auth/signup.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
