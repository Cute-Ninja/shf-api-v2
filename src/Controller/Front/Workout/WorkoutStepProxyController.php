<?php

namespace App\Controller\Front\Workout;

use App\Controller\AbstractProxyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutStepProxyController extends AbstractProxyController
{
    /**
     * @param Request $request
     * @param int     $workoutId
     *
     * @return Response
     */
    public function getMany(Request $request, int $workoutId): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutStepApiController:getMany',
            ['workoutId' => $workoutId]
        );
    }

    /**
     * @param Request $request
     * @param int     $workoutId
     * @param string  $stepType
     *
     * @return Response
     */
    public function post(Request $request, int $workoutId, string $stepType): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutStepApiController:getMany',
            ['workoutId' => $workoutId, 'stepType' => $stepType]
        );
    }

    /**
     * @param Request $request
     * @param int     $workoutId
     * @param int     $id
     *
     * @return Response
     */
    public function delete(Request $request, int $workoutId, int $id): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutStepApiController:delete',
            ['workoutId' => $workoutId, 'id' => $id]
        );
    }

    /**
     * @param Request $request
     * @param int     $workoutId
     * @param string  $action
     *
     * @return Response
     */
    public function patch(Request $request, int $workoutId, string $action): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutStepApiController:patch',
            ['workoutId' => $workoutId, 'action' => $action]
        );
    }
}