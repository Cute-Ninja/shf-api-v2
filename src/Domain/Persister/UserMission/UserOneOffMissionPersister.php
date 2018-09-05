<?php

namespace App\Domain\Persister\UserMission;

use App\Entity\Mission\Mission;
use App\Entity\User\User;

class UserOneOffMissionPersister extends AbstractUserMissionPersister
{
    /**
     * @param User $user
     */
    public function saveFavoriteWorkoutMission(User $user): void
    {
        $this->saveMission($user, Mission::FAVORITES_WORKOUT_MISSION_ID);
    }

    /**
     * @return array
     */
    protected function getUserMissionCriteria(): array
    {
        return [

        ];
    }
}