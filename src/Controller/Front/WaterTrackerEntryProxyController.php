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
        return $this->forward(
            'App\Controller\Api\WaterTrackerEntryApiController:post',
            ['trackerId' => $trackerId],
            ['user' => $this->getUser()->getId(), 'groups' => 'tracker-entries']
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
        $request->query->set('user', $this->getUser()->getId());

        return $this->forward(
            'App\Controller\Api\WaterTrackerEntryApiController:put',
            ['trackerId' => $trackerId, 'id' => $id],
            ['user' => $this->getUser()->getId(), 'groups' => 'tracker-entries']
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
        return $this->forward(
            'App\Controller\Api\WaterTrackerEntryApiController:delete',
            ['trackerId' => $trackerId, 'id' => $id],
            ['user' => $this->getUser()->getId(), 'groups' => 'tracker-entries']
        );
    }

}