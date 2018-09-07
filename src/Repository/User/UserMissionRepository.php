<?php

namespace App\Repository\User;

use App\Entity\User\UserMission;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method UserMission findOneByCriteria(array $criteria = [], array $selects = [])
 * @method UserMission[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class UserMissionRepository extends AbstractBaseRepository
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
     * @param int|int[]    $missionId
     *
     * @return bool
     */
    public function addCriterionMission(QueryBuilder $queryBuilder, $missionId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'mission', $missionId);
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
     * @param bool|null    $autoCalculated
     *
     * @return bool
     */
    public function addCriterionAutoCalculated(QueryBuilder $queryBuilder, ?bool $autoCalculated): bool
    {
        $queryBuilder->leftJoin($this->getAlias() . '.mission', 'user_mission_mission');
        $queryBuilder->addSelect('user_mission_mission');

        return $this->addCriterion($queryBuilder, 'user_mission_mission', 'autoCalculated', $autoCalculated);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'user_mission';
    }
}