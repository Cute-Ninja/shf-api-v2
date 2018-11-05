<?php

namespace App\Repository;

use App\Entity\AbstractBaseEntity;
use App\Repository\User\UserMissionRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractBaseRepository extends EntityRepository implements RepositoryInterface
{

    protected const ORDER_DIRECTION_ASC  = 'ASC';
    protected const ORDER_DIRECTION_DESC = 'DESC';

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder($this->getAlias())
                    ->select('DISTINCT ' . $this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByCriteria(array $criteria = [], array $selects = [])
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addSelects($queryBuilder, $this->addDefaultSelect($selects));
        $this->cleanQueryBuilder($queryBuilder);

        try {
            return $queryBuilder->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $exception) {
            // @TODO Log this case
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findManyByCriteriaBuilder(array $criteria = [], array $selects = [], array $orders = []): QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $this->addCriteria($queryBuilder, $this->addGenericCriteria($criteria))
             ->addOrderBys($queryBuilder, $orders)
             ->addSelects($queryBuilder, $this->addDefaultSelect($selects));
        $this->cleanQueryBuilder($queryBuilder);

        return $queryBuilder;
    }

    /**
     * @param array $criteria
     * @param array $selects
     * @param array $orders
     * @param int   $limit
     *
     * @return array
     */
    public function findManyByCriteria(array $criteria = [], array $selects = [], array $orders = [], $limit = null): array
    {
        $queryBuilder = $this->findManyByCriteriaBuilder($criteria, $selects, $orders);
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $criteria
     *
     * @return $this
     */
    public function addCriteria(QueryBuilder $queryBuilder, array $criteria = []): self
    {
        foreach ($criteria as $field => $value) {
            if ($field) {
                $this->{'addCriterion' . ucfirst($field)}($queryBuilder, $value);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     * @param string       $fieldName
     * @param mixed        $value
     * @param boolean      $exclude If true, we search different value
     *
     * @return boolean
     */
    public function addCriterion(QueryBuilder $queryBuilder, $alias, $fieldName, $value, $exclude = false): bool
    {
        [$condition, $parameter, $value] = $this->computeCriterionCondition($alias, $fieldName, $value, $exclude);
        if (null === $condition) {
            return false;
        }

        $queryBuilder->andWhere($condition);
        if (null !== $parameter) {
            $queryBuilder->setParameter($parameter, $value);
        }

        return true;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     * @param string       $fieldName
     * @param string       $value
     *
     * @return bool
     */
    public function addCriterionLike(QueryBuilder $queryBuilder, $alias, $fieldName, $value): bool
    {
        if (null === $value) {
            return false;
        }

        $parameter = $alias . '_' . $fieldName;
        $value     = '%' . $value . '%';
        $queryBuilder->andWhere("$alias.$fieldName LIKE :" . $parameter);
        $queryBuilder->setParameter($parameter, $value);
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addCriterionId(QueryBuilder $queryBuilder, $id): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'id', $id);
    }

    /**
     * {@inheritdoc}
     */
    public function addCriterionExcludedStatus(QueryBuilder $queryBuilder, $excludedStatus): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $excludedStatus, true);
    }

    /**
     * {@inheritdoc}
     */
    public function addCriterionStatus(QueryBuilder $queryBuilder, $status): bool
    {
        return $this->addCriterion($queryBuilder, $this->getAlias(), 'status', $status);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $orderBys
     *
     * @return $this
     */
    public function addOrderBys(QueryBuilder $queryBuilder, array $orderBys = []): self
    {
        foreach ($orderBys as $orderBy => $direction) {
            if ($orderBy) {
                $this->{'addOrderBy' . ucfirst($orderBy)}($queryBuilder, $direction);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $alias
     * @param string       $fieldName
     * @param string       $direction
     */
    public function addOrderBy(QueryBuilder $queryBuilder, $alias, $fieldName, $direction)
    {
        if (false === in_array($direction, [self::ORDER_DIRECTION_DESC, self::ORDER_DIRECTION_ASC], true)) {
            throw new \LogicException("$direction is not a valid value for order by 'direction' parameter.");
        }
        $queryBuilder->addOrderBy($alias . '.' . $fieldName, $direction);
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $selects
     *
     * @return $this
     */
    public function addSelects(QueryBuilder $queryBuilder, array $selects = []): self
    {
        foreach ($selects as $select) {
            if ($select) {
                $this->{'addSelect' . ucfirst($select)}($queryBuilder);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function cleanQueryBuilder(QueryBuilder $queryBuilder): QueryBuilder
    {
        $this->cleanQueryBuilderDqlPart($queryBuilder, 'join');
        $this->cleanQueryBuilderDqlPart($queryBuilder, 'select');

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $dqlPartName ('join', 'select', ...)
     */
    public function cleanQueryBuilderDqlPart(QueryBuilder $queryBuilder, $dqlPartName)
    {
        $dqlPart    = $queryBuilder->getDQLPart($dqlPartName);
        $newDqlPart = [];

        if (0 === count($dqlPart)) {
            return;
        }

        $queryBuilder->resetDQLPart($dqlPartName);
        if ('join' === $dqlPartName) {
            $this->cleanJoinFromQuery($queryBuilder, $dqlPart, $dqlPartName, $newDqlPart);

            return;
        }

        foreach ($dqlPart as $element) {
            $newDqlPart[$element->__toString()] = $element;
        }

        $dqlPart = array_values($newDqlPart);
        foreach ($dqlPart as $element) {
            $queryBuilder->add($dqlPartName, $element, true);
        }
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param              $dqlPart
     * @param string       $dqlPartName
     * @param array        $newDqlPart
     */
    private function cleanJoinFromQuery(QueryBuilder $queryBuilder, $dqlPart, string $dqlPartName, array $newDqlPart)
    {
        foreach ($dqlPart as $root => $elements) {
            foreach ($elements as $element) {
                preg_match(
                    '/^(?P<joinType>[^ ]+) JOIN (?P<join>[^ ]+) (?P<alias>[^ ]+)/',
                    $element->__toString(),
                    $matches
                );

                if (false === array_key_exists($matches['alias'], $newDqlPart)) {
                    $newDqlPart[$matches['alias']] = $element;
                }
            }
            $dqlPart[$root] = array_values($newDqlPart);
        }

        $dqlPart = array_shift($dqlPart);
        foreach ($dqlPart as $element) {
            $queryBuilder->add($dqlPartName, [$element], true);
        }
    }

    /**
     * @param string  $alias
     * @param string  $fieldName
     * @param mixed   $value
     * @param boolean $exclude If true, we search different value
     *
     * @return array
     */
    public function computeCriterionCondition($alias, $fieldName, $value, $exclude = false): array
    {
        if (null === $value) {
            return [null, null, null];
        }

        $operator       = $exclude ? '!=' : '=';
        $condition      = $alias . '.' . $fieldName . ' ' . $operator . ' :' . $alias . '_' . $fieldName;
        $parameterField = $alias . '_' . $fieldName;
        $parameterValue = $value !== false && empty($value) ? null : $value;

        if (is_array($value)) {
            $operator  = $exclude ? 'NOT IN' : 'IN';
            $condition = $alias . '.' . $fieldName . ' ' . $operator . ' (:' . $alias . '_' . $fieldName . ')';
        } elseif ('NULL' === $value) {
            $condition = $alias . '.' . $fieldName . ' IS NULL';
            $parameterField = null;
            $parameterValue = null;
        }elseif ('NOT NULL' === $value) {
            $condition = $alias . '.' . $fieldName . ' IS NOT NULL';
            $parameterField = null;
            $parameterValue = null;
        }

        return [$condition, $parameterField, $parameterValue];
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function addGenericCriteria(array $criteria = []): array
    {
        if (false === isset($criteria['status']) && property_exists($this->getEntityName(), 'status')) {
            $excludedStatus             = isset($criteria['excludedStatus']) ?? $criteria['excludedStatus'];
            $excludedStatus             = is_array($excludedStatus) ? $excludedStatus : [$excludedStatus];
            $criteria['excludedStatus'] = array_merge([AbstractBaseEntity::STATUS_DELETED], $excludedStatus);
        }

        return $criteria;
    }

    /**
     * @param array $selects
     *
     * @return array
     */
    public function addDefaultSelect(array $selects = []): array
    {
        return array_merge($selects, $this->getDefaultSelects());
    }

    /**
     * @return array
     */
    public function getDefaultSelects(): array
    {
        return [];
    }
}
