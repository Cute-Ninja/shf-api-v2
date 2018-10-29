<?php

namespace App\Controller\Api\Workout\ActionHelper;

use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\PersonalWorkout;
use App\Entity\Workout\ReferenceWorkout;
use App\Entity\User\UserFavoriteWorkout;
use App\Entity\Workout\TrainingPlanWorkout;
use App\Repository\Workout\WorkoutRepository;
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
            'source'     => $request->get('source'),
            'creator'    => $request->get('creator'),
            'status'     => $request->get('status')
        ];

        if (PersonalWorkout::TYPE_PERSONAL === $type) {
            $params['owner'] = $request->get('owner');
            $entityClass     = PersonalWorkout::class;
        } elseif (ReferenceWorkout::TYPE_REFERENCE === $type) {
            $entityClass     = ReferenceWorkout::class;
        } elseif(TrainingPlanWorkout::TYPE_TRAINING_PLAN === $type) {
            $entityClass     = TrainingPlanWorkout::class;
        } else {
            $entityClass     = AbstractWorkout::class;
        }

        /** @var WorkoutRepository $repository */
        $repository = $this->entityManager->getRepository($entityClass);

        return $repository->findManyByCriteriaBuilder($params);
    }
}