<?php

namespace App\Repository\Workout;

use Doctrine\ORM\QueryBuilder;

class PersonalWorkoutRepository extends WorkoutRepository
{
        /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $userId
     *
     * @return bool
     */
    public function addCriterionOwner(QueryBuilder $queryBuilder, $userId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'owner', $userId);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'personal_workout';
    }
}