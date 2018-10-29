<?php

namespace App\Domain\Persister\User;

use App\Domain\Manager\EmailManager;
use App\Domain\Persister\AbstractPersister;
use App\Entity\User\User;
use App\Repository\User\UserRepository;
use App\Utils\SecurityUtils;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPersister extends AbstractPersister
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var EmailManager
     */
    protected $emailManager;

    /**
     * @param ObjectManager                $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EmailManager                 $emailManager
     */
    public function __construct(
        ObjectManager $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        EmailManager $emailManager
    )
    {
        parent::__construct($entityManager);

        $this->passwordEncoder = $passwordEncoder;
        $this->emailManager    = $emailManager;
    }

    /**
     * @param User $user
     * @param bool $sendEmail
     *
     * @return User
     */
    public function create(User $user, bool $sendEmail): User
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setConfirmationKey(SecurityUtils::randomString(15));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if (true === $sendEmail) {
            $this->emailManager->sendEmailToUser(
                $user,
                'registration',
                [
                    'confirmationKey' => $user->getConfirmationKey()
                ]
            );
        }

        return $user;
    }


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
    private function getUserRepository(): UserRepository
    {
        return $this->entityManager->getRepository(User::class);
    }
}