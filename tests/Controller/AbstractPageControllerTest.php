<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractPageControllerTest extends WebTestCase implements ShfTestInterface
{
    /**
     * @param bool $saveUser
     *
     * @return Client
     */
    public function buildAuthenticatedUser($saveUser = false): Client
    {
        return $this->buildAuthentication(self::AUTHENTICATION_PERSONAL_USERNAME);
    }

    /**
     * @return Client
     */
    public function buildAuthenticatedAdmin(): Client
    {
        return $this->buildAuthentication(self::AUTHENTICATION_ADMIN_USERNAME);
    }

    /**
     * @param string $username
     *
     * @return Client
     */
    private function buildAuthentication(string $username): Client
    {
        return static::createClient(array(), array(
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => self::AUTHENTICATION_DEFAULT_PASSWORD,
        ));
    }
}