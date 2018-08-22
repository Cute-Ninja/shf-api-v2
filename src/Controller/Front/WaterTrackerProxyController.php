<?php

namespace App\Controller\Front;

use App\Controller\AbstractProxyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterTrackerProxyController extends AbstractProxyController
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
            'App\Controller\Api\WaterTrackerApiController:getMany'
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getToday(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\WaterTrackerApiController:getToday',
            [],
            ['groups' => ['tracker-entries']]
        );
    }
}