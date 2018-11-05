<?php

namespace App\Domain\Persister\UserMission;

use App\Utils\Clock;

class UserWeeklyMissionPersister extends AbstractUserMissionPersister
{
    /**
     * @return array
     */
    protected function getUserMissionCriteria(): array
    {
        return [
            'completedBetween' => [
                'start' => Clock::relativeDate('monday this week'),
                'end' => Clock::relativeDate('next monday')
            ]
        ];
    }
}