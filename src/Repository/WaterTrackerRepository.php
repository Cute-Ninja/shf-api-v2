<?php

namespace App\Repository;

use App\Entity\WaterTracker;
use Doctrine\ORM\QueryBuilder;

/**
 * @method WaterTracker findOneByCriteria(array $criteria = [], array $selects = [])
 */
class WaterTrackerRepository extends AbstractBaseRepository
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
     * @param QueryBuilder $queryBuilder
     * @param array        $interval
     *
     * @return bool
     */
    public function addCriterionCreatedBetween(QueryBuilder $queryBuilder, array $interval): bool
    {
        if (false === isset($interval['start']) || false === isset($interval['end'])) {
            return false;
        }

        $queryBuilder->andWhere($this->getAlias() . '.createdAt >= :start_date')
                     ->andWhere($this->getAlias() . '.createdAt <= :end_date')
                     ->setParameter('start_date', $interval['start'])
                     ->setParameter('end_date', $interval['end']);

        return true;
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function addSelectWaterTrackerEntry(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->leftJoin($this->getAlias() . '.entries', 'water_tracker_entry')
                     ->addSelect('water_tracker_entry');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'water_tracker';
    }
}