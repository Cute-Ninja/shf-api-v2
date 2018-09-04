<?php

namespace App\Repository\User;

use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

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
    public function addCriterionCompletedBetween(QueryBuilder $queryBuilder, array $interval): bool
    {
        if (false === isset($interval['start']) || false === isset($interval['end'])) {
            return false;
        }

        $queryBuilder->andWhere($this->getAlias() . '.completionDate >= :start_date')
                     ->andWhere($this->getAlias() . '.completionDate <= :end_date')
                     ->setParameter('start_date', $interval['start'])
                     ->setParameter('end_date', $interval['end']);

        return true;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'user_mission';
    }
}