<?php

namespace App\Tests\Controller\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @covers App\Controller\Api\UserApiController
 */
class UserApiControllerTest extends AbstractBaseApiTest
{
    public function testGetManyUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'users');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetManyAuthorized(): void
    {
        $client = $this->buildAuthenticatedAdmin();
        $this->buildGetRequest($client, 'users');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            $this->loadDataFromJsonFile('json/users'),
            json_decode($response->getContent(), true)
        );
    }

    public function testGetOneUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'users/ghriim');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetOneAuthorized(): void
    {
        $client = $this->buildAuthenticatedAdmin();
        $this->buildGetRequest($client, 'users/ghriim');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($this->loadDataFromJsonFile('json/user_ghriim'), json_decode($response->getContent(), true));
    }

    public function testGetOneNotFound(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'users/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostAnonymousWithoutFormError(): void
    {
        $client = static::createClient();
        $this->buildPostRequest(
            $client,
            'users/registration',
            [
                'username' => 'user_test',
                'email'    => 'user_test@fake.com',
                'password' => 'test123'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testPostAnonymousWithFormError(): void
    {
        $client = static::createClient();
        $this->buildPostRequest(
            $client,
            'users/registration',
            [
                'username' => 'user_test',
                'email'    => 'user_test@fake.com',
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testPutUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPutRequest(
            $client,
            'users/user_2',
            [
                'email' => 'test@test.com'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutForbidden(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest(
            $client,
            'users/user_2',
            [
                'email' => 'test@test.com'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPutNotFound(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest(
            $client,
            'users/not_existing',
            [
                'email' => 'test@test.com'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPutAuthorizedWithoutFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest(
            $client,
            'users/ghriim',
            [
                'username' => 'ghriim',
                'email' => 'test@test.com'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testPutAuthorizedWithFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest(
            $client,
            'users/ghriim',
            [
                'email' => 'test@test.com'
            ]
        );

        $response = $client->getResponse();
        $errors   = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertTrue(array_key_exists('username', $errors));
    }

    public function testDeleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildDeleteRequest($client, 'users/user_2');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testDeleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedAdmin();
        $this->buildDeleteRequest($client, 'users/user_1');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testDeleteNotFound(): void
    {
        $client = $this->buildAuthenticatedAdmin();
        $this->buildDeleteRequest($client, 'users/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }
}