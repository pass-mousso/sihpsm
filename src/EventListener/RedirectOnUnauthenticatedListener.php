<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class RedirectOnUnauthenticatedListener
{
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    #[AsEventListener(event: KernelEvents::REQUEST,  priority: -10)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

//        if ($request->attributes->has('_is_public')) {
//            $isPublic = $request->attributes->get('_is_public');
//        }

        if (str_starts_with($request->getPathInfo(), '/_')) {
            return;
        }

        // Vérifiez si l'utilisateur est connecté
        if (null === $this->security->getUser() && !$request->attributes->get('_is_public', false)) {
            $event->setResponse(new RedirectResponse($this->urlGenerator->generate('signin')));
        }
    }
}
