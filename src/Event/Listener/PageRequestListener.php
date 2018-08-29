<?php

namespace App\Event\Listener;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PageRequestListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(TokenStorageInterface $storage, RouterInterface $router)
    {
        $this->tokenStorage = $storage;
        $this->router = $router;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (null === $this->tokenStorage->getToken() || false === $this->isVisitorRoute($event->getRequest())) {
            return;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        if ($user instanceof User) {
            $destination = $user->isAdmin() ? 'admin_page_dashboard' : 'front_page_dashboard';
            $response = new RedirectResponse($this->router->generate($destination), 302, ['location' => 'test']);
            $event->setResponse($response);
        }
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function isVisitorRoute(Request $request): bool
    {
        $route = $request->attributes->get('_route');
        if (null === $route) {
            return false;
        }

        if ('login' !== $route && strpos($route, 'visitor_') !== 0) {
            return false;
        }

        return true;
    }
}