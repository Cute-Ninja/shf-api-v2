<?php

namespace App\Controller\Front;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterTrackerEntryProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     * @param string  $trackerId
     *
     * @return Response
     */
    public function post(Request $request, $trackerId): Response
    {
        $params = $request->query->all();
        $params['user']   = $this->getUser()->getId();
        $params['groups'] = $this->buildProxySerializationGroups($request, ['tracker-entries']);

        return $this->forward(
            'App\Controller\Api\WaterTrackerEntryApiController:post',
            ['trackerId' => $trackerId],
            $params
        );
    }

    /**
     * @param Request $request
     * @param string  $trackerId
     * @param string  $id
     *
     * @return Response
     */
    public function put(Request $request, $trackerId, $id): Response
    {
        $params = $request->query->all();
        $params['user']   = $this->getUser()->getId();
        $params['groups'] = $this->buildProxySerializationGroups($request, ['tracker-entries']);

        return $this->forward(
            'App\Controller\Api\WaterTrackerEntryApiController:put',
            ['trackerId' => $trackerId, 'id' => $id],
            $params
        );
    }

    /**
     * @param Request $request
     * @param string  $trackerId
     * @param string  $id
     *
     * @return Response
     */
    public function delete(Request $request, $trackerId, $id): Response
    {
        $params = $request->query->all();
        $params['user']   = $this->getUser()->getId();
        $params['groups'] = $this->buildProxySerializationGroups($request, ['tracker-entries']);

        return $this->forward(
            'App\Controller\Api\WaterTrackerEntryApiController:delete',
            ['trackerId' => $trackerId, 'id' => $id],
            $params
        );
    }

}