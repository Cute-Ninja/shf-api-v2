<?php

namespace App\Controller;

use App\Entity\AbstractBaseEntity;
use App\Entity\AbstractWorkout;
use App\Entity\User;
use App\Entity\UserFavoriteWorkout;
use App\Entity\UserWorkout;
use App\Entity\WaterTracker;
use App\Entity\WaterTrackerEntry;
use App\Repository\UserFavoriteWorkoutRepository;
use App\Repository\UserRepository;
use App\Repository\UserWorkoutRepository;
use App\Repository\WaterTrackerEntryRepository;
use App\Repository\WaterTrackerRepository;
use App\Repository\WorkoutRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\FOSRestController;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

abstract class AbstractBaseController extends FOSRestController
{
    protected const PAGINATION_PAGE_DEFAULT = 1;
    protected const PAGINATION_LIMIT_DEFAULT = 25;

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
     * @return ObjectManager
     */
    protected function getEntityManager(): ObjectManager
    {
        return $this->get('doctrine')->getManager();
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

    /**
     * @return UserRepository
     */
    protected function getUserRepository(): UserRepository
    {
        return $this->getEntityManager()->getRepository(User::class);
    }

    /**
     * @return WaterTrackerRepository
     */
    protected function getWaterTrackerRepository(): WaterTrackerRepository
    {
        return $this->getEntityManager()->getRepository(WaterTracker::class);
    }

    /**
     * @return WaterTrackerEntryRepository
     */
    protected function getWaterTrackerEntryRepository(): WaterTrackerEntryRepository
    {
        return $this->getEntityManager()->getRepository(WaterTrackerEntry::class);
    }

    /**
     * @return WorkoutRepository
     */
    public function getWorkoutRepository(): WorkoutRepository
    {
        return $this->getEntityManager()->getRepository(AbstractWorkout::class);
    }

    /***
     * @return UserFavoriteWorkoutRepository
     */
    protected function getUserFavoriteWorkoutRepository(): UserFavoriteWorkoutRepository
    {
        return $this->getEntityManager()->getRepository(UserFavoriteWorkout::class);
    }

    /**
     * @return UserWorkoutRepository
     */
    protected function getUserWorkoutRepository(): UserWorkoutRepository
    {
        return $this->getEntityManager()->getRepository(UserWorkout::class);
    }
}
