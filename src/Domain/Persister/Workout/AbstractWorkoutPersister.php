<?php

namespace App\Domain\Persister\Workout;

use App\Domain\Persister\AbstractPersister;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\AbstractWorkoutStep;

abstract class AbstractWorkoutPersister extends AbstractPersister
{
    /**
     * @param string $workoutStatus
     *
     * @return string
     */
    abstract protected function convertToStepStatus(string $workoutStatus): string;

    /**
     * @param AbstractWorkout $workout
     * @param string               $status
     *
     * @return AbstractWorkout
     */
    public function doStatusUpdate(AbstractWorkout $workout, $status): AbstractWorkout
    {
        $this->doStepStatusUpdate($workout, $status);
        $workout->setStatus($status);

        return $workout;
    }

    /**
     * @param AbstractWorkout $workout
     * @param string          $workoutStatus
     */
    protected function doStepStatusUpdate(AbstractWorkout $workout, string $workoutStatus): void
    {
        $steps = $this->entityManager
                      ->getRepository(AbstractWorkoutStep::class)
                      ->findManyByCriteria(['workout' => $workout]);

        $stepStatus = $this->convertToStepStatus($workoutStatus);
        foreach ($steps as $step) {
            $step->setStatus($stepStatus);
        }
    }
}