<?php

namespace App\Controller\Api\User\ActionHelper;

use App\Domain\Persister\UserMission\UserOneOffMissionPersister;
use App\Entity\User\UserFavoriteWorkout;
use Doctrine\Common\Persistence\ObjectManager;

class PostUserFavoriteWorkoutActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var UserOneOffMissionPersister
     */
    protected $oneOffMissionPersister;

    public function __construct(ObjectManager $entityManager, UserOneOffMissionPersister $oneOffMissionPersister)
    {
        $this->entityManager = $entityManager;
        $this->oneOffMissionPersister = $oneOffMissionPersister;
    }

    /**
     * @param UserFavoriteWorkout $favorite
     */
    public function saveFavorite(UserFavoriteWorkout $favorite): void
    {
        $this->entityManager->persist($favorite);

        $this->oneOffMissionPersister->saveFavoriteWorkoutMission($favorite->getUser());

        $this->entityManager->flush();
    }
}