<?php

namespace App\Event\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        $data['ip']   = $this->requestStack->getCurrentRequest()->getClientIp();
        $data['hash'] = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $event->setData($data);
    }
}