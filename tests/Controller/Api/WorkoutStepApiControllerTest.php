<?php

namespace App\Tests\Controller\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Api\WorkoutStepApiController
 */
class WorkoutStepApiControllerTest extends AbstractBaseApiTest
{
    public function testGetManyUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'workouts/7/steps');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetManyAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'workouts/7/steps');

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            $this->loadDataFromJsonFile('json/workouts_steps_half_preparation_1'),
            json_decode($response->getContent(), true)
        );
    }

    public function testGetOneUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'workouts/7/steps/13');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetOneAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'workouts/7/steps/13');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPostRequest($client, 'workouts/7/steps/amrap');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostAuthorizedWithFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest(
            $client,
            'workouts/7/steps/amrap',
            [
                'position' => 3,
                'exercise' => 0,
                'estimatedDuration' => 'not_a_number'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }


    public function testPostAuthorizedWithoutFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest(
            $client,
            'workouts/7/steps/amrap',
            [
                'position' => 3,
                'exercise' => 1,
                'estimatedDuration' => 60
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testPutUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPutRequest($client, 'workouts/7/steps/13');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest($client,'workouts/7/steps/13');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testDeleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildDeleteRequest($client, 'workouts/7/steps/1');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testDeleteNotFoundAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildDeleteRequest($client, 'workouts/0000/steps/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testDeleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildDeleteRequest($client, 'workouts/7/steps/13');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testPatchUnknownActionUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/7/steps/unknown', ['id' => 13]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPatchUnknownActionAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/7/steps/unknown', ['id' => 13]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPatchCompleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/7/steps/complete', ['id' => 13]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPatchCompleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/7/steps/complete', ['id' => 13]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testPatchUndoCompleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/7/steps/undo-complete', ['id' => 13]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPatchUndoCompleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/7/steps/undo-complete', ['id' => 13]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}