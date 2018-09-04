<?php

namespace App\Controller\Api\User\ActionHelper;

use App\Entity\Mission\Mission;
use App\Entity\User\User;
use App\Entity\User\UserMission;
use App\Exception\Http\NotImplementedHttpException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\Date;

class PatchMissionActionHelper
{
    private const PATCH_ACTION_COMPLETE = 'complete';

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $action
     * @param User   $user
     * @param int    $missionId
     *
     * @return UserMission
     *
     * @throws NotImplementedHttpException|NotFoundHttpException|AccessDeniedHttpException
     */
    public function doPatchAction(string $action, User $user, $missionId): UserMission
    {
        if (self::PATCH_ACTION_COMPLETE === $action) {
            return $this->completeMission($user, $missionId);
        }

        throw new NotImplementedHttpException();
    }

    /**
     * @param User $user
     * @param int  $missionId
     *
     * @return UserMission
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    public function completeMission(User $user, int $missionId): UserMission
    {
        $mission = $this->getMissionToComplete($missionId);
        if (null === $mission) {
            throw new NotFoundHttpException();
        }

        $userMission = $this->getUserMission($user, $mission);
        if (null !== $userMission) {
            throw new AccessDeniedHttpException();
        }

        $userMission = new UserMission($user, $mission);
        $userMission->setStatus(UserMission::STATUS_COMPLETED);

        $this->entityManager->persist($userMission);
        $this->entityManager->flush();

        return $userMission;
    }

    /**
     * @param int $missionId
     *
     * @return Mission
     */
    private function getMissionToComplete(int $missionId): Mission
    {
        return $this->entityManager
                    ->getRepository(Mission::class)
                    ->findOneByCriteria(
                        [
                            'id' => $missionId,
                            'autoCalculated' => false
                        ]
                    );
    }

    /**
     * @param User    $user
     * @param Mission $mission
     *
     * @return UserMission|null
     */
    private function getUserMission(User $user, Mission $mission): ?UserMission
    {
        $createdBetween = null;
        if (Mission::PERIODICITY_DAILY === $mission->getPeriodicity()) {
            $createdBetween = ['start' => new \DateTime('today'), 'end' => new \DateTime('tomorrow')];
        } elseif (Mission::PERIODICITY_WEEKLY === $mission->getPeriodicity()) {
            $createdBetween = [
                'start' => new \DateTime('monday this week'),
                'end' => new \DateTime('next monday')
            ];
        }

        return $this->entityManager
                    ->getRepository(UserMission::class)
                    ->findOneByCriteria(
                        [
                            'user' => $user,
                            'mission' => $mission,
                            'completedBetween' => $createdBetween,
                            'excludedStatus' => UserMission::STATUS_COMPLETED
                        ]
                    );
    }
}