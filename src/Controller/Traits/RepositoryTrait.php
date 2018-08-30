<?php

namespace App\Controller\Traits;

use App\Entity\AbstractWorkout;
use App\Entity\AbstractWorkoutStep;
use App\Entity\PersonalWorkout;
use App\Entity\ReferenceWorkout;
use App\Entity\User\User;
use App\Entity\User\UserFavoriteWorkout;
use App\Entity\WaterTracker;
use App\Entity\WaterTrackerEntry;
use App\Repository\PersonalWorkoutRepository;
use App\Repository\ReferenceWorkoutRepository;
use App\Repository\User\UserFavoriteWorkoutRepository;
use App\Repository\User\UserRepository;
use App\Repository\WaterTrackerEntryRepository;
use App\Repository\WaterTrackerRepository;
use App\Repository\WorkoutRepository;
use App\Repository\WorkoutStepRepository;
use Doctrine\Common\Persistence\ObjectManager;

trait RepositoryTrait
{
    /**
     * @return ObjectManager
     */
    abstract protected function getEntityManager(): ObjectManager;

    /**
     * @return UserRepository
     */
    protected function getUserRepository(): UserRepository
    {
        return $this->getEntityManager()->getRepository(User::class);
    }

    /**
     * @return WaterTrackerRepository
     */
    protected function getWaterTrackerRepository(): WaterTrackerRepository
    {
        return $this->getEntityManager()->getRepository(WaterTracker::class);
    }

    /**
     * @return WaterTrackerEntryRepository
     */
    protected function getWaterTrackerEntryRepository(): WaterTrackerEntryRepository
    {
        return $this->getEntityManager()->getRepository(WaterTrackerEntry::class);
    }

    /**
     * @return WorkoutRepository
     */
    public function getWorkoutRepository(): WorkoutRepository
    {
        return $this->getEntityManager()->getRepository(AbstractWorkout::class);
    }

    /**
     * @return ReferenceWorkoutRepository
     */
    public function getReferenceWorkoutRepository(): ReferenceWorkoutRepository
    {
        return $this->getEntityManager()->getRepository(ReferenceWorkout::class);
    }

    /**
     * @return PersonalWorkoutRepository
     */
    public function getPersonalWorkoutRepository(): PersonalWorkoutRepository
    {
        return $this->getEntityManager()->getRepository(PersonalWorkout::class);
    }

    /***
     * @return UserFavoriteWorkoutRepository
     */
    protected function getUserFavoriteWorkoutRepository(): UserFavoriteWorkoutRepository
    {
        return $this->getEntityManager()->getRepository(UserFavoriteWorkout::class);
    }

    /**
     * @return WorkoutStepRepository
     */
    protected function getWorkoutStepRepository(): WorkoutStepRepository
    {
        return $this->getEntityManager()->getRepository(AbstractWorkoutStep::class);
    }
}