<?php

namespace App\Repository\User;

use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

class UserBodyMeasurementHistoryRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $username
     *
     * @return bool
     */
    public function addCriterionUsername(QueryBuilder $queryBuilder, $username): bool
    {
        $queryBuilder->leftJoin($this->getAlias() . '.user', 'body_measurement_history_user');
        $queryBuilder->addSelect('body_measurement_history_user');

        return $this->addCriterion($queryBuilder, 'body_measurement_history_user', 'username', $username);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'body_measurement_history';
    }
}