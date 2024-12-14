<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\User;
use App\Entity\UserHospital;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\ThemeHelper;
use App\Service\TransactionService;
use App\Service\Utils;
use App\Utils\AjaxResponse;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/gestion/user')]
final class UserController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private Utils $utils,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private EmailService $emailService,
        private UserPasswordHasherInterface $passwordHasher,
        private TransactionService $transactionService
    )
    {
        parent::__construct($theme);
    }

    #[Route(name: 'admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $this->theme->addJavascriptFile('/js/admin/user/add.js');

        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('admin_user_new'),
            'method' => 'POST',
        ]);

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'form' => $form
        ]);
    }

    /**
     * @throws RandomException
     */
    #[Route('/new', name: 'admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $redirectUrl = '/';
        $currentUser = $this->getUser();
        $user = new User();

        // Création du formulaire
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('admin_user_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validation du formulaire
            $email = $form->get('email')->getData();
            $hospital = $form->get('hospital')->getData();
            $errors = $this->validateUserEmail($email);

            if (!empty($errors)) {
                return AjaxResponse::error('Erreur de validation', $errors);
            }

            // Génération des données utilisateur et liaison avec l'hôpital
            $plainPassword = $this->utils->generateUniqueId(length: 12, type: 'password');
            $this->prepareUser($user, $email, $plainPassword);

            $userHospital = (new UserHospital())
                ->setOwner($currentUser)
                ->setHospital($hospital);

            try {
                // Utilisation du service de transaction
                $this->transactionService->processTransaction([$user, $userHospital]);

                // Envoi de l'email de création
                $this->sendAccountCreationEmail($email, $plainPassword);

                return AjaxResponse::success(
                    'Opération effectuée avec succès',
                    redirectUrl: $redirectUrl
                );
            } catch (\Exception $e) {
                return AjaxResponse::error(
                    'Une erreur est survenue lors de la création du user',
                    ['transaction' => $e->getMessage()]
                );
            }
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            // Retour d'erreur si le formulaire est invalid
            return  AjaxResponse::error(
                'Une erreur est survenue lors de la création du user',
                [
                    $this->getErrors($form)
                ]
            );
        }

        // Gestion de la requête non AJAX
        if (!$request->isXmlHttpRequest()) {
            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }

        // Retour vide si la requête est en AJAX mais rien n'a été soumis
        return AjaxResponse::error('Aucune donnée reçue.');
    }

    #[Route('/{id}', name: 'admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getErrors(FormInterface $form): array
    {
        $errors = [];

        // Erreurs globales du formulaire
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        // Erreurs des champs individuels
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }

    private function validateUserEmail(string $email): array
    {
        if ($this->userRepository->checkEmail($email)) {
            return ['Cet email est déjà utilisé pour un autre utilisateur.'];
        }

        return [];
    }

    private function prepareUser(User $user, string $email, string $password): void
    {
        $user->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->setUsername($email);
    }

    private function sendAccountCreationEmail(string $email, string $password): void
    {
        $subject = 'Création de compte SIH';
        $template = '/emails/user_security_email.html.twig';
        $securityData = [
            'userEmail' => $email,
            'password' => $password,
        ];

        $this->emailService->sendSimpleEmail(to: $email, subject: $subject, content: $template, data: $securityData);
    }
}
