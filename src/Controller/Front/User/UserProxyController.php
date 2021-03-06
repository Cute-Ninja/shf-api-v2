<?php

namespace App\Controller\Front\User;

use App\Controller\AbstractProxyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProxyController extends AbstractProxyController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function me(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\User\UserApiController:getOne',
            ['username' => $this->getUser()->getUsername()],
            ['groups' => ['user-details', 'user-body-measurement']]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function post(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\User\UserApiController:post'
        );
    }
}