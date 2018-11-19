<?php

namespace App\Controller\Admin\Workout;

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
}