<?php

namespace App\Repository\Mission;

use App\Entity\Mission\Mission;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Mission findOneByCriteria(array $criteria = [], array $selects = [])
 * @method Mission[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class MissionRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param bool         $autoCalculated
     *
     * @return bool
     */
    public function addCriterionAutoCalculated(QueryBuilder $queryBuilder, bool $autoCalculated): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'autoCalculated', $autoCalculated);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'mission';
    }
}