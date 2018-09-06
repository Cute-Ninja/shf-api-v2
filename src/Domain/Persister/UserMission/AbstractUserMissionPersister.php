<?php

namespace App\Domain\Persister\UserMission;

use App\Entity\Mission\Mission;
use App\Entity\User\User;
use App\Entity\User\UserMission;
use App\Entity\WaterTracker\WaterTrackerEntry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class AbstractUserMissionPersister
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
     * @throws AccessDeniedHttpException
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

        return $userMission;
    }

    /**
     * @param User $user
     * @param int  $missionId
     * @param bool $autoCalculatedMission
     *
     * @return UserMission
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
     */
    private function getMissionById(int $missionId): Mission
    {
        return $this->entityManager
                    ->getRepository(Mission::class)
                    ->findOneByCriteria(['id' => $missionId]);
    }
}