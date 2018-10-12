<?php

namespace App\Controller\Api\User\ActionHelper;

use App\Domain\Manager\EmailManager;
use App\Entity\User\User;
use App\Utils\SecurityUtils;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PostUserActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

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
        $this->entityManager   = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->emailManager    = $emailManager;
    }

    /**
     * @param User $user
     */
    public function doPostAction(User $user): void
    {
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setConfirmationKey(SecurityUtils::randomString(15));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->emailManager->sendEmailToUser(
            $user,
            'registration',
            [
                'confirmationKey' => $user->getConfirmationKey()
            ]
        );
    }
}