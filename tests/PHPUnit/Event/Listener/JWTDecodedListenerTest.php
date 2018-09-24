<?php

namespace App\Tests\PHPUnit\Event\Listener;

use App\Event\Listener\JWTDecodedListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @covers \App\Event\Listener\JWTDecodedListener
 */
class JWTDecodedListenerTest extends TestCase
{
    /**
     * @param array  $payload
     * @param string $currentIp
     * @param bool   $expectedResult
     *
     * @dataProvider onJWTDecodedDataProvider
     */
    public function testOnJWTDecodedWithIpInPayload(array $payload, string $currentIp, bool $expectedResult): void
    {
        $requestStack   = $this->prophesize(RequestStack::class);
        $currentRequest = $this->prophesize(Request::class);

        $currentRequest->getClientIp()->willReturn($currentIp);
        $requestStack->getCurrentRequest()->willReturn($currentRequest);

        $listener = new JWTDecodedListener($requestStack->reveal());
        $event    = new JWTDecodedEvent($payload);

        $listener->onJWTDecoded($event);

        $this->assertEquals($expectedResult, $event->isValid());
    }

    public function testOnJWTDecodedWithNoIpInPayload(): void
    {
        $requestStack   = $this->prophesize(RequestStack::class);

        $listener = new JWTDecodedListener($requestStack->reveal());
        $event    = new JWTDecodedEvent([]);

        $listener->onJWTDecoded($event);

        $this->assertEquals(false, $event->isValid());
    }

    /**
     * @return array
     */
    public function onJWTDecodedDataProvider(): array
    {
        return [
            [['ip' => '127.0.0.1'], '127.0.0.1', true],
            [['ip' => '178.0.0.1'], '127.0.0.1', false],
        ];
    }
}