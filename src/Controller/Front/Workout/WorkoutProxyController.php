<?php

namespace App\Controller\Front\Workout;

use App\Controller\AbstractProxyController;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\PersonalWorkout;
use App\Entity\Workout\ReferenceWorkout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutProxyController extends AbstractProxyController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getManyPersonal(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:getMany',
            ['owner' => $request->query->get('owner') ?? $this->getUser()->getId()],
            ['type' => PersonalWorkout::TYPE_PERSONAL]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getManyReference(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:getMany',
            [],
            ['type' => ReferenceWorkout::TYPE_REFERENCE]
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function getOne(Request $request, int $id): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:getOne',
            ['id' => $id]
        );
    }

    /**
     * @param Request $request
     * @param string  $workoutType
     *
     * @return Response
     */
    public function postWithType(Request $request, string $workoutType): Response
    {
        $request->request->set('source', AbstractWorkout::WORKOUT_SOURCE_COMMUNITY);

        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:postWithType',
            ['workoutType' => $workoutType]
        );
    }

    /**
     * @param Request $request
     * @param string  $action
     *
     * @return Response
     */
    public function patch(Request $request, string $action): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:patch',
            ['action' => $action]
        );
    }
}