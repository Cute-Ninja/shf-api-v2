<?php

namespace App\Controller\Api\User\ActionHelper;

use App\Domain\Persister\UserMission\UserDailyMissionPersister;
use App\Entity\User\User;
use App\Entity\User\UserMission;
use App\Exception\Http\NotImplementedHttpException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchUserMissionActionHelper
{
    private const PATCH_ACTION_COMPLETE = 'complete';

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var UserDailyMissionPersister
     */
    protected $dailyMissionPersister;

    public function __construct(ObjectManager $entityManager, UserDailyMissionPersister $dailyMissionPersister)
    {
        $this->entityManager = $entityManager;
        $this->dailyMissionPersister = $dailyMissionPersister;
    }

    /**
     * @param string $action
     * @param User   $user
     * @param int    $missionId
     *
     * @return UserMission
     *
     * @throws NotImplementedHttpException|AccessDeniedHttpException
     */
    public function doPatchAction(string $action, User $user, $missionId): UserMission
    {
        if (null === $missionId) {
            throw new NotFoundHttpException();
        }

        $userMission = null;
        if (self::PATCH_ACTION_COMPLETE === $action) {
            $userMission = $this->dailyMissionPersister->saveManualMission($user, $missionId);

            $this->entityManager->flush();
        }

        return $userMission;
    }
}