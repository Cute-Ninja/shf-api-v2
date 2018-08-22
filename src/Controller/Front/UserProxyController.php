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
        $params = $request->query->all();
        $params['groups'] = $this->buildProxySerializationGroups($request, ['user-details', 'user-body-measurement']);

        return $this->forward(
            'App\Controller\Api\UserApiController:getOne',
            ['username' => $this->getUser()->getUsername()],
            $params
        );
    }
}