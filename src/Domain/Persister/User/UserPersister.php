<?php

namespace App\Domain\Persister\User;

use App\Domain\Persister\AbstractPersister;
use App\Entity\User\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserPersister extends AbstractPersister
{
    /**
     * @param string $confirmationKey
     *
     * @return User
     *
     * @throws NotFoundHttpException
     */
    public function activate(string $confirmationKey): User
    {
        $user = $this->getUserRepository()->findOneByCriteria(
            [
                'status' => User::STATUS_PENDING,
                'confirmationKey' => $confirmationKey
            ]
        );

        if(null === $user) {
            throw new NotFoundHttpException();
        }

        $user->setStatus(User::STATUS_ACTIVE);
        $user->setConfirmationKey(null);

        return $user;
    }

    /**
     * @return \App\Repository\User\UserRepository
     */
    private function getUserRepository()
    {
        return $this->entityManager->getRepository(User::class);
    }
}