<?php

namespace App\Domain\Persister\UserMission;

use App\Entity\Mission\Mission;
use App\Entity\User\User;
use App\Entity\User\UserMission;
use App\Entity\WaterTracker\WaterTrackerEntry;

class UserDailyMissionPersister extends AbstractUserMissionPersister
{
    /**
     * @param User $user
     * @param int  $missionId
     *
     * @return UserMission
     */
    public function saveManualMission(User $user, int  $missionId): UserMission
    {
        return $this->saveMission($user, $missionId, null, false);
    }

    /**
     * @param User              $user
     * @param WaterTrackerEntry $entry
     */
    public function saveWaterTrackerMission(User $user, WaterTrackerEntry $entry): void
    {
        $this->saveMission($user, Mission::WATER_TRACKER_DAILY_MISSION_ID, $entry->getQuantity());
    }

    /**
     * @return array
     */
    protected function getUserMissionCriteria(): array
    {
        return [
            'createdBetween' => [
                'start' => new \DateTime('today'),
                'end' => new \DateTime('tomorrow')
            ]
        ];
    }
}