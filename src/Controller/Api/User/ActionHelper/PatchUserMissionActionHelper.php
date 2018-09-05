<?php

namespace App\Controller\Api\User\ActionHelper;

use App\Domain\Persister\UserMission\UserDailyMissionPersister;
use App\Entity\Mission\Mission;
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
     * @throws NotImplementedHttpException|NotFoundHttpException|AccessDeniedHttpException
     */
    public function doPatchAction(string $action, User $user, $missionId): UserMission
    {
        $userMission = null;
        if (self::PATCH_ACTION_COMPLETE === $action) {
            $userMission = $this->dailyMissionPersister->saveManualMission($user, $missionId);
        } else {
            throw new NotImplementedHttpException();
        }

        if (null === $userMission) {
            throw new AccessDeniedHttpException();
        }

        $this->entityManager->flush();

        return $userMission;


    }
}