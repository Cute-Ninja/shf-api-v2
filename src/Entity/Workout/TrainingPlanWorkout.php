<?php

namespace App\Entity\Workout;

class TrainingPlanWorkout extends AbstractWorkout
{
    /**
     * @var TrainingPlan
     *
     * @Serializer\Groups({"training-plan"})
     */
    protected $trainingPlan;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_TRAINING_PLAN;
    }

    /**
     * @return TrainingPlan
     */
    public function getTrainingPlan(): TrainingPlan
    {
        return $this->trainingPlan;
    }

    /**
     * @param TrainingPlan $trainingPlan
     */
    public function setTrainingPlan(TrainingPlan $trainingPlan): void
    {
        $this->trainingPlan = $trainingPlan;
    }
}