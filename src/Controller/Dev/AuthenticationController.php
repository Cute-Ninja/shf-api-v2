<?php

namespace App\Controller\Dev;

use App\Controller\Api\AbstractApiController;
use App\Tests\PHPUnit\Controller\ShfTestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getToken(Request $request): Response
    {
        $username = $request->get('username', ShfTestInterface::AUTHENTICATION_PERSONAL_USERNAME);
        $user     = $this->getUserRepository()->findOneByCriteria(['username' => $username]);

        if (null === $user) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');

        return $this->getSuccessResponseBuilder()->ok(['token' => $jwtManager->create($user)]);
    }
}