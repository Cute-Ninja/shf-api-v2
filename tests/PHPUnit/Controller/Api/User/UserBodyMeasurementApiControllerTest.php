<?php

namespace App\Tests\PHPUnit\PHPUnit\Controller\Api\User;

use App\Tests\PHPUnit\Controller\Api\AbstractBaseApiTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Api\User\UserBodyMeasurementApiController
 */
class UserBodyMeasurementApiControllerTest extends AbstractBaseApiTest
{
    public function testGetManyUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'users/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetManyAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'users/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testGetOneUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'users/ghriim/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetOneAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'users/ghriim/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPostRequest($client, 'users/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest($client, 'users/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPutUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPutRequest($client, 'users/ghriim/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutAuthorizedNotFound(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest($client, 'users/not_existing/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPutAuthorizedWithFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest(
            $client,
            'users/ghriim/body-measurements',
            [
                'height' => 12,
                'weight' => 85,
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @group alterDB
     */
    public function testPutAuthorizedWithoutFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest(
            $client,
            'users/ghriim/body-measurements',
            [
                'height' => 175,
                'weight' => 85,
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), $response->getContent());
        $this->assertNotEmpty($response->getContent());

        $this->resetDB();
    }

    public function testDeleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildDeleteRequest($client, 'users/ghriim/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testDeleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildDeleteRequest($client, 'users/ghriim/body-measurements');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }
}