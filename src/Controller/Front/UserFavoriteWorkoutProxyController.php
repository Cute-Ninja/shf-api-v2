<?php

namespace App\Controller\Front;

use App\Controller\AbstractProxyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserFavoriteWorkoutProxyController extends AbstractProxyController
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
            'App\Controller\Api\UserFavoriteWorkoutApiController:getMany'
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function post(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\UserFavoriteWorkoutApiController:post'
        );
    }

    /**
     * @param Request $request
     * @param string  $id
     *
     * @return Response
     */
    public function delete(Request $request, $id): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\UserFavoriteWorkoutApiController:post',
            ['id' => $id]
        );
    }
}