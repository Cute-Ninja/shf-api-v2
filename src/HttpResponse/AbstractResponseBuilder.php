<?php

namespace App\HttpResponse;

use App\Domain\Manager\NotificationManager;
use App\Entity\User\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Psr\SimpleCache\InvalidArgumentException;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractResponseBuilder
{
    /**
     * @var ViewHandler
     */
    protected $viewHandler;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var NotificationManager
     */
    protected $notificationManager;

    /**
     * AbstractResponseBuilder constructor.
     *
     * @param ViewHandler           $viewHandler
     * @param TokenStorageInterface $storage
     * @param NotificationManager   $notificationManager
     */
    public function __construct(
        ViewHandler $viewHandler,
        TokenStorageInterface $storage,
        NotificationManager $notificationManager
    )
    {
        $this->viewHandler = $viewHandler;
        $this->tokenStorage = $storage;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return Response
     */
    public function ok($data = null, array $headers = []): Response
    {
        $code = null === $data || true === empty($data) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK ;

        return $this->handle(View::create($data, $code, $headers));
    }

    /**
     * @param View $view
     *
     * @return Response
     */
    protected function handle(View $view): Response
    {
        if ($token = $this->tokenStorage->getToken()) {
            $user = $token->getUser();
            if ($user instanceof User && false === $user->isAdmin()) {
                $view->setHeader(
                    'SHF-Notification-Count',
                    $this->notificationManager->getWebNotificationCount($user)
                );
            }
        }

        return $this->viewHandler->handle($view);
    }
}
