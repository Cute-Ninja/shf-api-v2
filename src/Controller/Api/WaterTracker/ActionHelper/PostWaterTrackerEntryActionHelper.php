<?php

namespace App\Controller\Api\WaterTracker\ActionHelper;

use App\Entity\Mission\Mission;
use App\Entity\User\User;
use App\Entity\User\UserMission;
use App\Entity\WaterTracker\WaterTrackerEntry;
use Doctrine\Common\Persistence\ObjectManager;

class PostWaterTrackerEntryActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User              $user
     * @param WaterTrackerEntry $entry
     */
    public function saveEntry(User $user, WaterTrackerEntry $entry): void
    {
        $this->entityManager->persist($entry);

        $this->updateWaterTrackerMission($user, $entry);

        $this->entityManager->flush();
    }

    /**
     * @param User              $user
     * @param WaterTrackerEntry $entry
     */
    private function updateWaterTrackerMission(User $user, WaterTrackerEntry $entry): void
    {
        $userTrackerMission = $this->entityManager
                                   ->getRepository(UserMission::class)
                                   ->findOneByCriteria(
                                       [
                                           'user'           => $user,
                                           'mission'        => Mission::WATER_TRACKER_DAILY_MISSION_ID,
                                           'createdBetween' => [
                                               'start' => new \DateTime('today'),
                                               'end'   => new \DateTime('tomorrow')
                                           ]
                                       ]
                                   );

        if (null === $userTrackerMission) {
            $userTrackerMission = new UserMission($user, $this->getWaterTrackerMission());
        }

        $userTrackerMission->incrementCurrent($entry->getQuantity());

        $this->entityManager->persist($userTrackerMission);
    }

    /**
     * @return Mission
     */
    private function getWaterTrackerMission(): Mission
    {
        return $this->entityManager
                    ->getRepository(Mission::class)
                    ->findOneByCriteria(['id' => Mission::WATER_TRACKER_DAILY_MISSION_ID]);
    }
}