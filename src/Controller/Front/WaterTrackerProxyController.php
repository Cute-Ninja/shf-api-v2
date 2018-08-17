<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterTrackerProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMany(Request $request): Response
    {
        return $this->forward(
            'App\Controller\Api\WaterTrackerApiController:getMany',
            [],
            ['user' => $this->getUser()->getId()]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getToday(Request $request): Response
    {
        return $this->forward(
            'App\Controller\Api\WaterTrackerApiController:getToday',
                [],
                ['user' => $this->getUser()->getId(), 'groups' => 'tracker-entries']
            );
    }
}