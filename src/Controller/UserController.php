<?php

namespace App\Controller;

use App\Controller\Bootstrap\DefaultLayoutController;
use App\Entity\User;
use App\Entity\UserHospital;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\ThemeHelper;
use App\Service\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/gestion/user')]
final class UserController extends DefaultLayoutController
{
    public function __construct(
        ThemeHelper $theme,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private Utils $utils
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
        $response = [];
        $errors = [];

        $currentUser = $this->getUser();

        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('admin_user_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $hospital = $form->get('hospital')->getData();
                $email = $form->get('email')->getData();
                $plainPassword = $this->utils->generateUniqueId(length: 12, type: 'password');

                $userTenant = new UserHospital();
                $userTenant->setOwner($currentUser)
                    ->setHospital($hospital);

                if (!$this->userRepository->checkEmail($email))
                {
                    $errors[] = 'Cet email est déjà utilisé pour un autre utilisateur.';
                }

                $user->setPassword($plainPassword)
                    ->setUsername($email);

                // Début de la transaction
                $this->entityManager->beginTransaction();

                try {
                    $this->entityManager->persist($userTenant);
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    // Validation de la transaction
                    $this->entityManager->commit();

                    $response = [
                       'status' => true,
                       'message' => 'Opération effectuée avec succès',
                       'redirectUrl' => $redirectUrl,
                    ];
                } catch (\Exception $e) {
                    // Annulation de la transaction en cas d'erreur
                    $this->entityManager->rollback();

                    $errors = [
                        'transaction' => $e->getMessage(),
                        'errors' => $this->getErrors($form)
                    ];

                    $response = [
                       'status' => false,
                       'message' => 'Une erreur est survenue lors de la création du user',
                        'errors' => $errors,
                    ];
                }
            } else {
                $response = [
                   'status' => false,
                   'message' => 'Une erreur est survenue lors de la création du user',
                    'errors' => $this->getErrors($form),
                ];
            }
        }

        if ($request->isXmlHttpRequest())
        {
            return $this->json($response);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
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

}
