<?php

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;

class UserWorkoutRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $userId
     *
     * @return bool
     */
    public function addCriterionUser(QueryBuilder $queryBuilder, $userId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'user', $userId);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'user_workout';
    }
}