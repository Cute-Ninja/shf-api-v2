<?php

namespace App\Controller\Admin\Workout;

use App\Controller\AbstractProxyController;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\ReferenceWorkout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutProxyController extends AbstractProxyController
{

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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function post(Request $request): Response
    {
        $request->request->add(
            ['source' => AbstractWorkout::WORKOUT_SOURCE_SHF]
        );

        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:postWithType',
            ['workoutType' => AbstractWorkout::TYPE_REFERENCE]
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function put(Request $request, int $id): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\Workout\WorkoutApiController:put',
            ['id' => $id]
        );
    }
}