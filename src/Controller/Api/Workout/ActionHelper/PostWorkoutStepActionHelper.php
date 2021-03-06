<?php

namespace App\Controller\Api\Workout\ActionHelper;

use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\AbstractWorkoutStep;

class PostWorkoutStepActionHelper
{
    /**
     * @param string          $stepType
     * @param AbstractWorkout $workout
     *
     * @return AbstractWorkoutStep
     */
    public function buildStepFromType(string $stepType, AbstractWorkout $workout): AbstractWorkoutStep
    {
        $className = 'Workout' . ucfirst($stepType) . 'Step';
        $classPath = "App\\Entity\\Workout\\$className";

        /** @var AbstractWorkoutStep $step */
        $step = new $classPath;
        $step->setWorkout($workout);

        return $step;
    }

    /**
     * @param string $stepType
     *
     * @return string
     */
    public function buildFormNameFromType(string $stepType): string
    {
        $className = 'Workout' . ucfirst($stepType) . 'StepType';

        return "App\\Form\\Type\\Workout\\$className";
    }
}