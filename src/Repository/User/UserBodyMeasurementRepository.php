<?php

namespace App\Repository\User;

use App\Entity\User\UserBodyMeasurement;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method UserBodyMeasurement findOneByCriteria(array $criteria = [], array $selects = [])
 * @method UserBodyMeasurement[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class UserBodyMeasurementRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $username
     *
     * @return bool
     */
    public function addCriterionUsername(QueryBuilder $queryBuilder, $username): bool
    {
        $queryBuilder->leftJoin($this->getAlias() . '.user', 'body_measurement_user');
        $queryBuilder->addSelect('body_measurement_user');

        return $this->addCriterion($queryBuilder, 'body_measurement_user', 'username', $username);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'body_measurement';
    }
}