<?php

namespace App\Tests\HttpResponse;

use App\HttpResponse\ServerErrorResponseBuilder;
use MongoDB\Driver\Exception\AuthenticationException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers App\HttpResponse\ServerErrorResponseBuilder
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
        $response = $this->responseBuilder->notImplemented();

        $this->assertEquals(Response::HTTP_NOT_IMPLEMENTED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    /**
     * @param \Exception $exception
     * @param int        $expectedCode
     * @param string     $expectedContent
     *
     * @dataProvider exceptionDataProvider
     */
    public function testException(\Exception $exception, int $expectedCode, string $expectedContent = null): void
    {
        $response = $this->responseBuilder->exception($exception);

        $this->assertEquals($expectedCode, $response->getStatusCode());
        $this->assertEquals($expectedContent, $response->getContent());
    }

    /**
     * @return array
     */
    public function exceptionDataProvider(): array
    {
        return [
            [new \LogicException(), Response::HTTP_INTERNAL_SERVER_ERROR, null],
            [new AuthenticationException(), Response::HTTP_INTERNAL_SERVER_ERROR, null],
            [new \Exception('Gate away error', Response::HTTP_BAD_GATEWAY), Response::HTTP_BAD_GATEWAY, 'Gate away error'],
        ];
    }
}