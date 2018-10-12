<?php

namespace App\Controller\Api\User\ActionHelper;

use App\Domain\Persister\User\UserPersister;
use App\Entity\User\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchUserActionHelper
{
    private const PATCH_ACTION_ACTIVATE = 'complete';

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var UserPersister
     */
    protected $userPersister;

    /**
     * @param ObjectManager $entityManager
     * @param UserPersister $userPersister
     */
    public function __construct(ObjectManager $entityManager, UserPersister $userPersister)
    {
        $this->entityManager = $entityManager;
        $this->userPersister = $userPersister;
    }

    /**
     * @param string      $action
     * @param User|null   $user
     * @param string|null $confirmationKey
     *
     * @return User
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    public function doPatchAction(
        string $action,
        User $user = null,
        string $confirmationKey = null
    ): User {
        if (self::PATCH_ACTION_ACTIVATE === $action && null === $user) {
            $user = $this->userPersister->activate($confirmationKey);

            $this->entityManager->flush();
        }

        return $user;
    }
}