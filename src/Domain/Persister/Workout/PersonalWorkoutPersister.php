<?php

namespace App\Domain\Persister\Workout;

use App\Entity\User\User;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\AbstractWorkoutStep;
use App\Entity\Workout\PersonalWorkout;
use App\Entity\Workout\ReferenceWorkout;

class PersonalWorkoutPersister extends AbstractWorkoutPersister
{
    /**
     * @param User            $user
     * @param AbstractWorkout $workout
     * @param \DateTime|null  $dateTime
     *
     * @return PersonalWorkout
     */
    public function scheduleOnce(User $user, AbstractWorkout $workout, \DateTime $dateTime = null): PersonalWorkout
    {
        if ($workout instanceof ReferenceWorkout) {
            $workout = $this->buildPersonalFromReference($workout);
            $workout->setOwner($user);
        }

        $workout->setScheduledDate($dateTime ?? new \DateTime());

        return $workout;
    }

    /**
     * @param ReferenceWorkout $reference
     *
     * @return PersonalWorkout
     */
    protected function buildPersonalFromReference(ReferenceWorkout $reference): PersonalWorkout
    {
        $workout = new PersonalWorkout();
        $workout->setName($reference->getName());
        $workout->setSource($reference->getSource());
        $workout->setCreator($reference->getCreator());
        $workout->setEstimatedDuration($reference->getEstimatedDuration());
        $workout->setDifficulty($reference->getDifficulty());
        $workout->setExperience($reference->getExperience());
        $workout->setCalories($reference->getCalories());

        $this->entityManager->persist($workout);

        return $workout;
    }

    /**
     * @param string $workoutStatus
     *
     * @return string
     */
    protected function convertToStepStatus(string $workoutStatus): string
    {
        $stepStatus = AbstractWorkoutStep::STATUS_ACTIVE;
        if (PersonalWorkout::STATUS_COMPLETED === $workoutStatus) {
            $stepStatus = AbstractWorkoutStep::STATUS_DONE;
        }

        return $stepStatus;
    }
}