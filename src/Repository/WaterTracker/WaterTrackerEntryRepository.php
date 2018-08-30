<?php

namespace App\Repository\WaterTracker;

use App\Entity\WaterTracker\WaterTrackerEntry;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method WaterTrackerEntry findOneByCriteria(array $criteria = [], array $selects = [])
 */
class WaterTrackerEntryRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $waterTrackerId
     *
     * @return bool
     */
    public function addCriterionWaterTrackerId(QueryBuilder $queryBuilder, $waterTrackerId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'tracker', $waterTrackerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'water_tracker_entry';
    }
}