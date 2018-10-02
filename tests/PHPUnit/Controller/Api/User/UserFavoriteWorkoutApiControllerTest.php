<?php

namespace App\Tests\PHPUnit\PHPUnit\Controller\Api\User;

use App\Tests\PHPUnit\Controller\Api\AbstractBaseApiTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Api\User\UserFavoriteWorkoutApiController
 */
class UserFavoriteWorkoutApiControllerTest extends AbstractBaseApiTest
{
    public function testGetManyUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'favorite-workouts');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetManyAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser(true);
        $this->buildGetRequest(
            $client,
            'favorite-workouts',
            ['user' => $this->user->getId()]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            $this->loadDataFromJsonFile('json/favorite_workouts_ghriim'),
            json_decode($response->getContent(), true)
        );
    }

    public function testGetOneUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'favorite-workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetOneAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'favorite-workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPostRequest($client, 'favorite-workouts');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostAuthorizedWithFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest(
            $client,
            'favorite-workouts',
            [
                'user' => 'not_existing',
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @group alterDB
     */
    public function testPostAuthorizedWithoutFormError(): void
    {
        $client = $this->buildAuthenticatedUser(true);
        $this->buildPostRequest(
            $client,
            'favorite-workouts',
            [
                'user'    => $this->user->getId(),
                'workout' => 6 // Ares lvl 2 Workout
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());

        $this->resetDB();
    }

    public function testPutUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPutRequest($client, 'favorite-workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest($client,'favorite-workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testDeleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildDeleteRequest($client, 'favorite-workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @group alterDB
     */
    public function testDeleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();

        $this->buildDeleteRequest($client, 'favorite-workouts/' . 1); // Ares workout

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertEmpty($response->getContent());

        $this->resetDB();
    }

    public function testDeleteNotFound(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildDeleteRequest($client, 'favorite-workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }
}