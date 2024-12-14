<?php

namespace App\EventListener;

use App\Repository\HospitalRepository;
use App\Service\Subscription\SubscriptionChecker;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

final class SubscriptionCheckListener
{
    public function __construct(
        private Security $security,
        private HospitalRepository $hospitalRepository,
        private SubscriptionChecker $subscriptionChecker,
        private RouterInterface $router
    ){}

    #[AsEventListener(event: KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Vérifiez si cette route nécessite un abonnement actif
        if (!$request->attributes->get('_route') === 'admin_gestion_hospital') {
            return;
        }

        $user = $this->security->getUser();
        if (!$user && (!$request->attributes->get('_route') === 'signin')) {
            $event->setResponse(new RedirectResponse($this->router->generate('signin')));
            return;
        }

        $hospital = $this->hospitalRepository->findOneBy(['owner' => $user]);

        if (!$hospital || !$this->subscriptionChecker->hasActiveSubscription()) {
//            throw new AccessDeniedHttpException('Abonnement actif requis.');
        }
    }
}
