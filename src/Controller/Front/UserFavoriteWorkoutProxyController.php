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
        return $this->forward(
            'App\Controller\Api\UserFavoriteWorkoutApiController:getMany',
            [],
            ['user' => $this->getUser()->getId()]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function post(Request $request): Response
    {
        return $this->forward(
            'App\Controller\Api\UserFavoriteWorkoutApiController:post',
            [],
            ['user' => $this->getUser()->getId()]
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
        $request->query->set('user', $this->getUser()->getId());

        return $this->forward(
            'App\Controller\Api\UserFavoriteWorkoutApiController:delete',
            ['id' => $id],
            ['user' => $this->getUser()->getId()]
        );
    }
}