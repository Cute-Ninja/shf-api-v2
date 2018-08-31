<?php

namespace App\Repository\Workout;

use App\Entity\Workout\TrainingPlan;

/**
 * @method TrainingPlan findOneByCriteria(array $criteria = [], array $selects = [])
 * @method TrainingPlan[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class TrainingPlanRepository extends WorkoutRepository
{
    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'reference_training_plan';
    }
}