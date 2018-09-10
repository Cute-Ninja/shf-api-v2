<?php

namespace App\Tests\HttpResponse;

use App\HttpResponse\ServerErrorResponseBuilder;
use MongoDB\Driver\Exception\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\HttpResponse\ServerErrorResponseBuilder
 */
class ServerErrorResponseBuilderTest extends WebTestCase
{
    /**
     * @var ServerErrorResponseBuilder
     */
    protected $responseBuilder;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        $this->responseBuilder = self::$container->get('shf.response_builder.server_error');
    }

    public function testNotImplemented(): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/not-implemented');

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    /**
     * @param string|null $exceptionName
     * @param int         $expectedCode
     * @param string      $expectedContent
     *
     * @dataProvider exceptionDataProvider
     */
    public function testException(?string $exceptionName, int $expectedCode, string $expectedContent = null): void
    {
        $client = static::createClient();
        $client->request('GET', '/errors/exception/' . $exceptionName);

        $response = $client->getResponse();

        $this->assertEquals($expectedCode, $response->getStatusCode());
        $content = json_decode($response->getContent());
        $this->assertEquals($expectedContent, $content->message);
    }

    /**
     * @return array
     */
    public function exceptionDataProvider(): array
    {
        return [
            ['annotation', Response::HTTP_INTERNAL_SERVER_ERROR, null],
            ['common', Response::HTTP_INTERNAL_SERVER_ERROR, 'global exception'],
        ];
    }
}