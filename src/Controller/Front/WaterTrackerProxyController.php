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
        $params = $request->query->all();
        $params['user'] = $this->getUser()->getId();

        return $this->forward(
            'App\Controller\Api\WaterTrackerApiController:getMany',
            [],
            $params
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getToday(Request $request): Response
    {
        $params = $request->query->all();
        $params['user']   = $this->getUser()->getId();
        $params['groups'] = $this->buildProxySerializationGroups($request, ['tracker-entries']);

        return $this->forward(
            'App\Controller\Api\WaterTrackerApiController:getToday',
                [],
            $params
            );
    }
}