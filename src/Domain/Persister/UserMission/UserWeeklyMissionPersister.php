<?php

namespace App\Domain\Persister\UserMission;

class UserWeeklyMissionPersister extends AbstractUserMissionPersister
{
    /**
     * @return array
     */
    protected function getUserMissionCriteria(): array
    {
        return [
            'completedBetween' => [
                'start' => new \DateTime('monday this week'),
                'end' => new \DateTime('next monday')
            ]
        ];
    }
}