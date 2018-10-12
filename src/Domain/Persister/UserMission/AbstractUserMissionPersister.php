<?php

namespace App\Domain\Persister\UserMission;

use App\Domain\Manager\NotificationManager;
use App\Domain\Persister\AbstractPersister;
use App\Entity\Mission\Mission;
use App\Entity\User\User;
use App\Entity\User\UserMission;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractUserMissionPersister extends AbstractPersister
{
    /**
     * @var NotificationManager
     */
    protected $notificationManager;

    /**
     * AbstractUserMissionPersister constructor.
     *
     * @param ObjectManager       $entityManager
     * @param NotificationManager $notificationManager
     */
    public function __construct(ObjectManager $entityManager, NotificationManager $notificationManager)
    {
        parent::__construct($entityManager);

        $this->notificationManager = $notificationManager;
    }

    abstract protected function getUserMissionCriteria();

    /**
     * @param User      $user
     * @param int       $missionId
     * @param int|null  $incrementCurrentValue
     * @param bool|null $autoCalculatedMission
     *
     * @return UserMission
     *
     * @throws AccessDeniedHttpException|NotFoundHttpException
     */
    protected function saveMission(
        User $user,
        int $missionId,
        int $incrementCurrentValue = null,
        ?bool $autoCalculatedMission = true
    ): UserMission
    {
        $userMission = $this->getUserMission($user, $missionId, $autoCalculatedMission);
        if (UserMission::STATUS_COMPLETED === $userMission->getStatus()) {
            throw new AccessDeniedHttpException();
        }

        $userMission->incrementCurrent($incrementCurrentValue);
        $this->entityManager->persist($userMission);

        if (UserMission::STATUS_COMPLETED === $userMission->getStatus()) {
            $this->notificationManager->notify($user, $userMission->getMission()->getName());
        }

        return $userMission;
    }

    /**
     * @param User $user
     * @param int  $missionId
     * @param bool $autoCalculatedMission
     *
     * @return UserMission
     *
     * @throws NotFoundHttpException
     */
    private function getUserMission(User $user, int $missionId, bool $autoCalculatedMission): UserMission
    {
        $commonCriteria = [
            'user'           => $user->getId(),
            'mission'        => $missionId,
            'autoCalculated' => $autoCalculatedMission
        ];

        $userMission = $this->entityManager
                            ->getRepository(UserMission::class)
                            ->findOneByCriteria(array_merge($commonCriteria, $this->getUserMissionCriteria()));

        if (null === $userMission) {
            $userMission = new UserMission($user, $this->getMissionById($missionId));
        }

        return $userMission;
    }

    /**
     * @param int $missionId
     *
     * @return Mission
     *
     * @throws NotFoundHttpException
     */
    private function getMissionById(int $missionId): Mission
    {
        $mission = $this->entityManager
                        ->getRepository(Mission::class)
                        ->findOneByCriteria(['id' => $missionId]);

        if (null === $mission) {
            throw  new NotFoundHttpException();
        }

        return $mission;
    }
}