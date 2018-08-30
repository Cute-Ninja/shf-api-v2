<?php

namespace App\tests\Entity;

use App\Entity\User\User;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\User
 */
class UserTest extends TestCase
{
    public function testHasRoleFailure(): void
    {
        $user = new User();
        $user->setRoles(['ROLES_USER']);

        $this->assertFalse($user->hasRole('ROLES_ADMIN'));
    }

    public function testHasRoleSuccess(): void
    {
        $user = new User();
        $user->setRoles(['ROLES_USER']);

        $this->assertTrue($user->hasRole('ROLES_USER'));
    }
}
