<?php

namespace App\Controller\Front;

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
            'App\Controller\Api\WorkoutStepApiController:getMany',
            ['workoutId' => $workoutId]
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
            'App\Controller\Api\WorkoutStepApiController:delete',
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
            'App\Controller\Api\WorkoutStepApiController:patch',
            ['workoutId' => $workoutId, 'action' => $action]
        );
    }
}