<?php

namespace App\Controller\Admin\User;

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
    public function getMany(Request $request): Response
    {
        return $this->forwardToApi(
            $request,
            'App\Controller\Api\User\UserApiController:getMany'
        );
    }

    /**
     * @param Request $request
     * @param string  $username
     *
     * @return Response
     */
    public function getOne(Request $request, string $username): Response
    {
        $request->query->set('groups', 'admin,lifecycle');

        return $this->forwardToApi(
            $request,
            'App\Controller\Api\User\UserApiController:getOne',
            ['username' => $username]
        );
    }
}