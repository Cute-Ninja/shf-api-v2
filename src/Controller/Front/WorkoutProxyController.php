<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use App\Entity\PersonalWorkout;
use App\Entity\ReferenceWorkout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getManyPersonal(Request $request): Response
    {
        $params = $request->query->all();
        $params['type'] = PersonalWorkout::TYPE_PERSONAL;

        return $this->forward(
            'App\Controller\Api\WorkoutApiController:getMany',
            [],
            $params
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getManyReference(Request $request): Response
    {
        $params = $request->query->all();
        $params['type'] = ReferenceWorkout::TYPE_REFERENCE;

        return $this->forward(
            'App\Controller\Api\WorkoutApiController:getMany',
            [],
            $params
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
        $params = $request->query->all();

        return $this->forward(
            'App\Controller\Api\WorkoutApiController:getOne',
            ['id' => $id],
            $params
        );
    }
}