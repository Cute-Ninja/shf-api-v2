<?php

namespace App\Controller\Api\ActionHelper;

use App\Entity\AbstractWorkout;
use App\Entity\PersonalWorkout;
use App\Entity\ReferenceWorkout;
use App\Entity\User\UserFavoriteWorkout;
use App\Repository\UserFavoriteWorkoutRepository;
use App\Repository\WorkoutRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class GetManyWorkoutActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     *
     * @return QueryBuilder
     */
    public function getWorkoutBuilder(Request $request): QueryBuilder
    {
        $type = $request->get('type');
        $params = [
            'source'  => $request->get('source'),
            'creator' => $request->get('creator'),
            'status'  => $request->get('status')
        ];

        if (PersonalWorkout::TYPE_PERSONAL === $type) {
            $params['owner'] = $request->get('owner');
            $entityClass     = PersonalWorkout::class;
        } elseif (ReferenceWorkout::TYPE_REFERENCE === $type) {
            $entityClass     = ReferenceWorkout::class;
        } else {
            $entityClass     = AbstractWorkout::class;
        }

        /** @var WorkoutRepository $repository */
        $repository = $this->entityManager->getRepository($entityClass);

        return $repository->findManyByCriteriaBuilder($params);
    }

    /**
     * @param int $userId
     */
    public function loadFavoriteWorkoutIds(int $userId): void
    {
        $repository = $this->entityManager->getRepository(UserFavoriteWorkout::class);
        $favorites  = $repository->findManyByCriteria(['user' => $userId]);

        if (false === empty($favorites)) {
            foreach ($favorites as $favorite) {
                $favorite->getWorkout()->setFavoriteId($favorite->getId());
            }
        }
    }
}