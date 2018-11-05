<?php

namespace App\Controller\Admin\Workout;

use App\Controller\AbstractProxyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutProxyController extends AbstractProxyController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMany(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:getMany'
        );
    }
}