<?php

namespace App\Repository\User;

use App\Entity\User\User;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method User findOneByCriteria(array $criteria = [], array $selects = [])
 * @method User[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class UserRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $username
     *
     * @return bool
     */
    public function addCriterionUsername(QueryBuilder $queryBuilder, $username): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'username', $username);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param bool         $isAdmin
     *
     * @return bool
     */
    public function addCriterionIsAdmin(QueryBuilder $queryBuilder, $isAdmin): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'isAdmin', $isAdmin);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $confirmationKey
     *
     * @return bool
     */
    public function addCriterionConfirmationKey(QueryBuilder $queryBuilder, string $confirmationKey): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'confirmationKey', $confirmationKey);
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function addSelectUserBodyMeasurement(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->leftJoin($this->getAlias() . '.bodyMeasurement', 'body_measurement');
        $queryBuilder->addSelect('body_measurement');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'user';
    }
}