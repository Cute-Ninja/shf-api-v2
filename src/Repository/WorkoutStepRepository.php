<?php

namespace App\Repository;

use App\Entity\AbstractWorkoutStep;
use Doctrine\ORM\QueryBuilder;

/**
 * @method AbstractWorkoutStep findOneByCriteria(array $criteria = [], array $selects = [])
 */
class WorkoutStepRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $workoutId
     *
     * @return bool
     */
    public function addCriterionWorkout(QueryBuilder $queryBuilder, $workoutId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'workout', $workoutId);
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function addSelectExercise(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->leftJoin($this->getAlias() . '.exercise', 'workout_step_exercise')
                     ->addSelect('workout_step_exercise');
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $direction
     */
    public function addOrderByPosition(QueryBuilder $queryBuilder, $direction): void
    {
        $this->addOrderBy($queryBuilder, $this->getAlias(), 'position', $direction);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'workout_step';
    }
}