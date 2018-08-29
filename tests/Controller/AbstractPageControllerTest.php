<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\AbstractBaseRepository;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
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
        $client  = static::createClient();
        $user = $this->getRepository($client, User::class)->findOneByCriteria(['username' => $username]);
        if (null === $user) {
            throw new AuthenticationException('User could not be found for username ' . $username);
        }

        $session = $client->getContainer()->get('session');

        $token = new UsernamePasswordToken($user, null, 'secure_area', $user->getRoles());
        $session->set('_security_secured_area', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }

    /**
     * @param Client $client
     * @param string $className
     *
     * @return AbstractBaseRepository
     */
    protected function getRepository(Client $client, $className): AbstractBaseRepository
    {
        $manager = $client->getContainer()->get('doctrine')->getManager();

        return $manager->getRepository($className);
    }
}