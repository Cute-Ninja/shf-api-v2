<?php

namespace App\Tests\Controller\Api;

use App\Entity\WaterTracker;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Api\WaterTrackerEntryApiController
 */
class WaterTrackerEntryApiControllerTest extends AbstractBaseApiTest
{
    /**
     * @var WaterTracker
     */
    private $trackerDay;

    public function testGetManyUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'water-trackers/not_existing/entries');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetManyAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'water-trackers/not_existing/entries');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testGetOneUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildGetRequest($client, 'water-trackers/not_existing/entries/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testGetOneAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildGetRequest($client, 'water-trackers/not_existing/entries/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testPostUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPostRequest($client, 'water-trackers/not_existing/entries');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostAuthorizedWithFormError(): void
    {
        $client = $this->buildAuthenticatedUser(true);

        $trackerDay = $this->getTrackerDay($client);

        $this->buildPostRequest(
            $client,
            'water-trackers/' . $trackerDay->getId() . '/entries',
            [
                'quantity' => 'not_valid'
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testPostAuthorizedWithoutFormError(): void
    {
        $client = $this->buildAuthenticatedUser(true);

        $trackerDay = $this->getTrackerDay($client);

        $this->buildPostRequest(
            $client,
            'water-trackers/' . $trackerDay->getId() . '/entries',
            [
                'quantity' => 150
            ]
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    public function testPutUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildPutRequest($client, 'water-trackers/not_existing/entries/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPutAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser();
        $this->buildPutRequest($client,'water-trackers/not_existing/entries/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testDeleteUnauthorized(): void
    {
        $client = static::createClient();
        $this->buildDeleteRequest($client, 'water-trackers/not_existing/entries/not_existing');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testDeleteAuthorized(): void
    {
        $client = $this->buildAuthenticatedUser( true);

        $trackerDay = $this->getTrackerDay($client);
        $trackerEntry = $trackerDay->getEntries()[0];

        $this->buildDeleteRequest($client, 'water-trackers/' . $trackerDay->getId() . '/entries/' . $trackerEntry->getId());

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * @param Client $client
     *
     * @return WaterTracker
     */
    private function getTrackerDay(Client $client): WaterTracker
    {
        if (null === $this->trackerDay) {
            $this->trackerDay = $this->getDocumentRepository($client, WaterTracker::class)
                                     ->findOneByCriteria(['user' => $this->user->getId()]);
        }

        return $this->trackerDay;
    }
}