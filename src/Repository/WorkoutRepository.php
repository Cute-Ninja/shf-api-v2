<?php

namespace App\Repository;

use App\Entity\PersonalWorkout;
use App\Entity\ReferenceWorkout;
use Doctrine\ORM\QueryBuilder;

class WorkoutRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $type
     *
     * @return bool
     */
    public function addCriterionType(QueryBuilder $queryBuilder, $type): bool
    {
        if (PersonalWorkout::TYPE_PERSONAL === $type) {
            $class = PersonalWorkout::class;
        } elseif (ReferenceWorkout::TYPE_REFERENCE=== $type) {
            $class = ReferenceWorkout::class;
        } else {
            return false;
        }

        $queryBuilder->andWhere($this->getAlias() . ' INSTANCE OF :type')
                     ->setParameter('type', $class);

        return true;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $userId
     *
     * @return bool
     */
    public function addCriterionCreator(QueryBuilder $queryBuilder, $userId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'creator', $userId);
    }

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $source
     *
     * @return bool
     */
    public function addCriterionSource(QueryBuilder $queryBuilder, $source): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'source', $source);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'workout';
    }
}