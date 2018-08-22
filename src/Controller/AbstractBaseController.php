<?php

namespace App\Controller;

use App\Controller\Traits\RepositoryTrait;
use App\Entity\AbstractBaseEntity;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\FOSRestController;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

abstract class AbstractBaseController extends FOSRestController
{
    use RepositoryTrait;

    protected const PAGINATION_PAGE_DEFAULT = 1;
    protected const PAGINATION_LIMIT_DEFAULT = 25;

    /**
     * @return ObjectManager
     */
    protected function getEntityManager(): ObjectManager
    {
        return $this->get('doctrine')->getManager();
    }

    /**
     * @param QueryBuilder $builder
     * @param Request      $request
     *
     * @return SlidingPagination
     */
    protected function paginate(QueryBuilder $builder, Request $request): SlidingPagination
    {
        return $this->container
                    ->get('knp_paginator')
                    ->paginate(
                        $builder,
                        $this->getPageForPagination($request),
                        $this->getLimitForPagination($request)
                    );
    }

    /**
     * @return Router
     */
    protected function getRouter(): Router
    {
        return $this->container->get('router');
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    protected function getPageForPagination(Request $request): int
    {
        return $request->get('page', self::PAGINATION_PAGE_DEFAULT);
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    protected function getLimitForPagination(Request $request): int
    {
        return $request->get('itemPerPage', self::PAGINATION_LIMIT_DEFAULT);
    }

    /**
     * @param Request $request
     *
     * @return string|array
     */
    protected function getSerializationGroup(Request $request)
    {
        $requestGroups = $request->get('groups');

        $groups = explode(',', $requestGroups);
        if ('test' !== $requestGroups) {
            $groups[] = AbstractBaseEntity::SERIALIZER_GROUP_DEFAULT;
        }

        return $groups;
    }


}
