<?php

namespace App\Controller\Api\ActionHelper;

use App\Entity\AbstractWorkout;
use App\Entity\User;

class PostWorkoutActionHelper
{

    /**
     * @param string $workoutType
     * @param User   $creator
     * @param string $source
     *
     * @return AbstractWorkout
     */
    public function buildWorkoutFromType(string $workoutType, User $creator): AbstractWorkout
    {
        $className = ucfirst($workoutType) . 'Workout';
        $classPath = "App\\Entity\\$className";

        /** @var AbstractWorkout $workout */
        $workout = new $classPath;
        $workout->setCreator($creator);

        return $workout;
    }

    /**
     * @param string $workoutType
     *
     * @return string
     */
    public function buildFormNameFromType(string $workoutType): string
    {
        $className = ucfirst($workoutType) . 'WorkoutType';

        return "App\\Form\\Type\\$className";
    }
}