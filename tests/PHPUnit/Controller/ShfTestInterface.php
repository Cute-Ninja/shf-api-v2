<?php

namespace App\Tests\PHPUnit\Controller;

use Symfony\Bundle\FrameworkBundle\Client;

interface ShfTestInterface
{
    public const AUTHENTICATION_ADMIN_USERNAME = 'ghost';
    public const AUTHENTICATION_PERSONAL_USERNAME = 'ghriim';
    public const AUTHENTICATION_DEFAULT_PASSWORD = 'test123';

    public function buildAuthenticatedUser($saveUser = false): Client;

    public function buildAuthenticatedAdmin(): Client;
}