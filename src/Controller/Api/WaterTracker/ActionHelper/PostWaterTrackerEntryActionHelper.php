<?php

namespace App\Controller\Api\WaterTracker\ActionHelper;

use App\Domain\Persister\UserMission\UserDailyMissionPersister;
use App\Entity\User\User;
use App\Entity\WaterTracker\WaterTrackerEntry;
use Doctrine\Common\Persistence\ObjectManager;

class PostWaterTrackerEntryActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var UserDailyMissionPersister
     */
    protected $dailyMissionPersister;

    /**
     * PostWaterTrackerEntryActionHelper constructor.
     *
     * @param ObjectManager             $entityManager
     * @param UserDailyMissionPersister $dailyMissionPersister
     */
    public function __construct(ObjectManager $entityManager, UserDailyMissionPersister $dailyMissionPersister)
    {
        $this->entityManager = $entityManager;
        $this->dailyMissionPersister = $dailyMissionPersister;
    }

    /**
     * @param User              $user
     * @param WaterTrackerEntry $entry
     */
    public function saveEntry(User $user, WaterTrackerEntry $entry): void
    {
        $this->entityManager->persist($entry);

        $this->dailyMissionPersister->saveWaterTrackerMission($user, $entry);

        $this->entityManager->flush();
    }
}