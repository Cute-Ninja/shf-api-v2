<?php

namespace App\Controller\Front;

use App\Controller\AbstractProxyController;
use App\Entity\PersonalWorkout;
use App\Entity\ReferenceWorkout;
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
            'App\Controller\Api\WorkoutApiController:getMany',
            [],
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
            'App\Controller\Api\WorkoutApiController:getMany',
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
            'App\Controller\Api\WorkoutApiController:getOne',
            ['id' => $id]
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
            'App\Controller\Api\WorkoutApiController:patch',
            ['action' => $action]
        );
    }
}