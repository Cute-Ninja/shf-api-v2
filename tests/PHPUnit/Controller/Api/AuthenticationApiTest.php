<?php

namespace App\Tests\Controller\Api;

use Symfony\Component\HttpFoundation\Response;

class AuthenticationApiTest extends AbstractBaseApiTest
{
    public function testLoginFail(): void
    {
        $client = static::createClient();
        $this->buildPostRequest(
            $client,
            'login_check',
            [
                'username' => 'test',
                'password' => 'test'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testUserLoginSuccess(): void
    {
        $client = static::createClient();
        $this->buildPostRequest(
            $client,
            'login_check',
            [
                'username' => self::AUTHENTICATION_PERSONAL_USERNAME,
                'password' => self::AUTHENTICATION_DEFAULT_PASSWORD
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testAdminLoginSuccess(): void
    {
        $client = static::createClient();
        $this->buildPostRequest(
            $client,
            'login_check',
            [
                'username' => self::AUTHENTICATION_ADMIN_USERNAME,
                'password' => self::AUTHENTICATION_DEFAULT_PASSWORD
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}