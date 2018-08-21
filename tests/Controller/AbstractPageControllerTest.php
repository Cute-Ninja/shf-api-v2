<?php

namespace App\Tests\Controller;

use Throwable;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractPageControllerTest extends WebTestCase implements ShfTestInterface
{
    /**
     * @var Client
     */
    protected $client;

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
     * {@inheritdoc}
     */
    protected function onNotSuccessfulTest(Throwable $exception)
    {
        $message = null;
        if (null !== $this->client->getCrawler()) {
            $message = $this->client->getCrawler()->filter('.exception-message')->text();
        }

        if (null !== $message) {
            $exceptionClass = get_class($exception);
            throw new $exceptionClass($exception->getMessage() . ' | ' . $message);
        }

        throw $exception;
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