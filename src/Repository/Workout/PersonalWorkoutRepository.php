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
     * @param QueryBuilder $queryBuilder
     * @param array        $interval
     *
     * @return bool
     */
    public function addCriterionScheduledBetween(QueryBuilder $queryBuilder, array $interval): bool
    {
        if (false === isset($interval['start']) || false === isset($interval['end'])) {
            return false;
        }

        $queryBuilder->andWhere($this->getAlias() . '.scheduledDate >= :start_date')
                     ->andWhere($this->getAlias() . '.scheduledDate <= :end_date')
                     ->setParameter('start_date', $interval['start'])
                     ->setParameter('end_date', $interval['end']);

        return true;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'personal_workout';
    }
}
