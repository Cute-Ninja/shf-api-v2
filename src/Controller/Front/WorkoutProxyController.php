<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMany(Request $request): Response
    {
        return $this->forward(
            'App\Controller\Api\WorkoutApiController:getMany',
            [],
            ['user' => $this->getUser()->getId(), 'groups' => $request->get('groups')]
        );
    }
}