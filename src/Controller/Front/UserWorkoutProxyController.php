<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserWorkoutProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMany(Request $request): Response
    {
        $queryParameters = $request->query->all();
        $queryParameters['user']   = $this->getUser()->getId();
        $queryParameters['groups'] = 'workout';

        return $this->forward(
            'App\Controller\Api\UserWorkoutApiController:getMany',
            [],
            $queryParameters
        );
    }
}