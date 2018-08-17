<?php

namespace App\Controller\Admin;

use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProxyController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMany(Request $request): Response
    {
        $request->query->set('groups', 'user-body-measurement');

        return $this->forward('App\Controller\Api\UserApiController:getMany');
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

        return $this->forward('App\Controller\Api\UserApiController:getOne', ['username' => $username]);
    }
}