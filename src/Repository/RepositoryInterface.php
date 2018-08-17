<?php

namespace App\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

interface RepositoryInterface
{
    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder;

    /**
     * @param array $criteria
     * @param array $selects
     *
     * @return mixed
     */
    public function findOneByCriteria(array $criteria = [], array $selects = []);

    /**
     * @param array $criteria
     * @param array $orders
     * @param array $selects
     *
     * @return QueryBuilder
     */
    public function findManyByCriteriaBuilder(array $criteria = [], array $selects = [], array $orders = []): QueryBuilder;

    /**
     * @param QueryBuilder $queryBuilder
     * @param int|int[]    $id
     *
     * @return bool
     */
    public function addCriterionId(QueryBuilder $queryBuilder, $id): bool;

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $status
     *
     * @return bool
     */
    public function addCriterionExcludedStatus(QueryBuilder $queryBuilder, $status): bool;

    /**
     * @param QueryBuilder    $queryBuilder
     * @param string|string[] $status
     *
     * @return bool
     */
    public function addCriterionStatus(QueryBuilder $queryBuilder, $status): bool;
}
