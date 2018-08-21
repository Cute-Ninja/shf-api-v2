<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutStepProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     * @param int     $workoutId
     *
     * @return Response
     */
    public function getMany(Request $request, int $workoutId): Response
    {
        return $this->forward(
            'App\Controller\Api\WorkoutStepApiController:getMany',
            ['workoutId' => $workoutId],
            ['groups' => $request->get('groups')]
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
        return $this->forward(
            'App\Controller\Api\WorkoutStepApiController:delete',
            ['workoutId' => $workoutId, 'id' => $id],
            ['groups' => $request->get('groups')]
        );
    }

}