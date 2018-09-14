<?php

namespace App\Tests\HttpResponse;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\HttpResponse\ClientErrorResponseBuilder
 */
class ClientErrorResponseBuilderTest extends WebTestCase
{
    public function testForbidden(): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/forbidden');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testUnauthorized(): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/unauthorized');

        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }


    public function testNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/not-found');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testBadRequest(): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/bad-request');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $responseContent = json_decode($response->getContent());
        $this->assertEquals('Not good', $responseContent->message);
    }

    public function testFormError(): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/form-error');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $responseContent = json_decode($response->getContent());
        $this->assertEquals(['global error 1', 'global error 2'], $responseContent->global);
        $this->assertEquals(['field_1 error 1'], $responseContent->field_1);
    }
}