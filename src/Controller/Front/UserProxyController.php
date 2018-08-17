<?php

namespace App\Controller\Front;

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
    public function me(Request $request): Response
    {
        return $this->forward(
            'App\Controller\Api\UserApiController:getOne',
            ['username' => $this->getUser()->getUsername()],
            ['groups' => 'user-details,user-body-measurement']
        );
    }
}