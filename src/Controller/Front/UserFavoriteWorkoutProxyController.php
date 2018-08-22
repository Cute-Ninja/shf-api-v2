<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserFavoriteWorkoutProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMany(Request $request): Response
    {
        $params = $request->query->all();
        $params['user'] = $this->getUser()->getId();

        return $this->forward(
            'App\Controller\Api\UserFavoriteWorkoutApiController:getMany',
            [],
            $params
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function post(Request $request): Response
    {
        $params = $request->query->all();
        $params['user'] = $this->getUser()->getId();

        return $this->forward(
            'App\Controller\Api\UserFavoriteWorkoutApiController:post',
            [],
            $params
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
        $params = $request->query->all();
        $params['user'] = $this->getUser()->getId();

        return $this->forward(
            'App\Controller\Api\UserFavoriteWorkoutApiController:delete',
            ['id' => $id],
            $params
        );
    }
}