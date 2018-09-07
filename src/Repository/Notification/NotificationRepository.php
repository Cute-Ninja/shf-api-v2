<?php

namespace App\Repository\Notification;

use App\Entity\Notification\AbstractNotification;
use App\Repository\AbstractBaseRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method AbstractNotification findOneByCriteria(array $criteria = [], array $selects = [])
 * @method AbstractNotification[] findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
 */
class NotificationRepository extends AbstractBaseRepository
{
    /**
     * @param QueryBuilder   $queryBuilder
     * @param int|int[]|null $userId
     *
     * @return bool
     */
    public function addCriterionUser(QueryBuilder $queryBuilder, $userId): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'user', $userId);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'notification';
    }
}