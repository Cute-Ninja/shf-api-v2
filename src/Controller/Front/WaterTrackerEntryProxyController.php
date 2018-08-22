<?php

namespace App\Controller\Front;

use App\Controller\AbstractProxyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WaterTrackerEntryProxyController extends AbstractProxyController
{
    /**
     * @param Request $request
     * @param string  $trackerId
     *
     * @return Response
     */
    public function post(Request $request, $trackerId): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\WaterTrackerEntryApiController:post',
            ['trackerId' => $trackerId],
            ['groups' => ['tracker-entries']]
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
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\WaterTrackerEntryApiController:put',
            ['trackerId' => $trackerId, 'id' => $id],
            ['groups' => ['tracker-entries']]
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
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\WaterTrackerEntryApiController:delete',
            ['trackerId' => $trackerId, 'id' => $id],
            ['groups' => ['tracker-entries']]
        );
    }

}