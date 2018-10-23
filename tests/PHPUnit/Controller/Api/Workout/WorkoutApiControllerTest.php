<?php

namespace App\Tests\PHPUnit\Controller\Api\Workout;

use App\Entity\Workout\PersonalWorkout;
use App\Entity\Workout\ReferenceWorkout;
use App\Tests\PHPUnit\Controller\Api\AbstractBaseApiTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Api\Workout\WorkoutApiController
 */
class WorkoutApiControllerTest extends AbstractBaseApiTest
{
    public function testGetManyUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'workouts');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetManyAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest(
            $client,
            'workouts',
            ['type' => ReferenceWorkout::TYPE_REFERENCE]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            $this->loadDataFromJsonFile('json/workouts_reference'),
            json_decode($response->getContent(), true)
        );
    }

    public function testGetOneUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetOneAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPostRequest($client, 'workouts');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest($client, 'workouts');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostWithTypeUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPostRequest($client, 'workouts/personal');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostWithTypeAuthorizedWithFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest(
            $client,
            'workouts/personal',
            [
                'name' => '',
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @group alterDB
     */
    public function testPostWithTypeAuthorizedWithoutFormError(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPostRequest(
            $client,
            'workouts/personal',
            [
                'name' => 'test workout',
                'source' => 'shf'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $this->assertNotEmpty($response->getContent());

        $this->resetDB();
    }

    public function testPutUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPutRequest($client, 'workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest($client,'workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testDeleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildDeleteRequest($client, 'workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testDeleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildDeleteRequest($client, 'workouts/0000');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
    }

    public function testPatchUnknownActionUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/unknown', ['id' => 7]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPatchUnknownActionAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/unknown', ['id' => 7]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testPatchCompleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/complete', ['id' => 7]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @group alterDB
     */
    public function testPatchCompleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/complete', ['id' => 7]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            $this->loadDataFromJsonFile('json/workouts_half_preparation_1_complete'),
            json_decode($response->getContent(), true)
        );

        $this->resetDB();
    }

    public function testPatchUndoCompleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/undo-complete', ['id' => 7]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @group alterDB
     */
    public function testPatchUndoCompleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/undo-complete', ['id' => 7]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(
            $this->loadDataFromJsonFile('json/workouts_half_preparation_1_undo_complete'),
            json_decode($response->getContent(), true)
        );

        $this->resetDB();
    }

    /**
     * @group alterDB
     */
    public function testPatchScheduleUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPatchRequest($client, 'workouts/schedule', ['id' => 1]);

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    /**
     * @group alterDB
     */
    public function testPatchScheduleAuthorizedWithoutDate(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/schedule', ['id' => 7]); // Personal workout

        $response = $client->getResponse();
        $responseContent = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($responseContent['status'], PersonalWorkout::STATUS_SCHEDULED);

        $this->resetDB();
    }

    /**
     * @group alterDB
     */
    public function testPatchScheduleAuthorizedWithDate(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPatchRequest($client, 'workouts/schedule', ['id' => 1, 'scheduledDate' => '2099-01-01 00:00:00']); // Reference Workout

        $response = $client->getResponse();
        $responseContent = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($responseContent['status'], PersonalWorkout::STATUS_SCHEDULED);
        $this->assertEquals($responseContent['scheduledDate'], '2099-01-01T00:00:00+00:00');

        $this->resetDB();
    }
}