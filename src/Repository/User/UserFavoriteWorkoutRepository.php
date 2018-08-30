<?php

namespace App\Repository\User;

use App\Entity\User\UserFavoriteWorkout;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method UserFavoriteWorkout findOneByCriteria(array $criteria = [], array $selects = [])
 * @method UserFavoriteWorkout[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class UserFavoriteWorkoutRepository extends AbstractBaseRepository
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
     */
    public function addSelectUser(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->leftJoin($this->getAlias() . '.user', 'favorite_user');
        $queryBuilder->addSelect('favorite_user');
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function addSelectWorkout(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->leftJoin($this->getAlias() . '.workout', 'favorite_workout');
        $queryBuilder->addSelect('favorite_workout');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'user_favorite_workout';
    }
}