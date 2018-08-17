<?php

namespace App\Tests\Event\Listener;

use App\Entity\User;
use App\Event\Listener\JWTCreatedListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @covers App\Event\Listener\JWTCreatedListener
 */
class JWTCreatedListenerTest extends TestCase
{
    /**
     * @param string $username
     * @param array  $roles
     * @param string $expectedUsername
     * @param array  $expectedRoles
     * @param string $expectedIp
     *
     * @dataProvider userInformationDataProvider
     */
    public function testOnAuthenticationSuccessResponse(string $username, array $roles, $expectedUsername, array $expectedRoles, $expectedIp): void
    {
        $user = new User();
        $user->setUsername($username);
        $user->setRoles($roles);

        $requestStack = $this->getMockBuilder(RequestStack::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $currentRequest = $this->getMockBuilder(Request::class)
                                ->disableOriginalConstructor()
                                ->getMock();

        $currentRequest->expects($this->once())
                       ->method('getClientIp')
                       ->willReturn('127.0.0.1');

        $requestStack->expects($this->once())
                     ->method('getCurrentRequest')
                     ->willReturn($currentRequest);

        $listener = new JWTCreatedListener($requestStack);
        $event    = new JWTCreatedEvent([], $user, []);

        $listener->onJWTCreated($event);

        $user = $event->getUser();
        $data = $event->getData();

        $this->assertEquals($expectedUsername, $user->getUsername());
        $this->assertEquals($expectedRoles, $user->getRoles());
        $this->assertEquals($expectedIp, $data['ip']);
    }

    /**
     * @return array
     */
    public function userInformationDataProvider(): array
    {
        return [
            ['username1', ['ROLES_A'],'username1', ' roles' => ['ROLES_A'], '127.0.0.1'],
            ['username2', ['ROLES_A', 'ROLES_B'], 'username2', ['ROLES_A', 'ROLES_B'], '127.0.0.1'],
            ['username3', [], 'username3', ['ROLES_USER'], '127.0.0.1'],
        ];
    }
}