<?php

namespace App\Tests\Controller\Api;

use App\Entity\User;
use App\Repository\AbstractBaseRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

abstract class AbstractBaseApiTest extends WebTestCase
{
    public const AUTHORIZATION_HEADER_PREFIX = 'Bearer';
    public const AUTHENTICATION_ADMIN_USERNAME = 'ghost';
    public const AUTHENTICATION_PERSONAL_USERNAME = 'ghriim';
    public const AUTHENTICATION_DEFAULT_PASSWORD = 'test123';

    /**
     * @var User
     */
    public $user;

    protected function setUp()
    {
        $process = new Process('make test_reset_db');
        $process->setTimeout(3600);
        $process->run();
    }

    /**
     * @param bool $saveUser
     *
     * @return Client
     */
    protected function buildAuthenticatedUser($saveUser = false): Client
    {
        $client = $this->buildAuthentication(self::AUTHENTICATION_PERSONAL_USERNAME);

        if (true === $saveUser && null === $this->user) {
            $this->user = $this->getDocumentRepository($client, User::class)
                               ->findOneByCriteria(['username' => self::AUTHENTICATION_PERSONAL_USERNAME]);
        }

        return $client;
    }

    /**
     * @return Client
     */
    protected function buildAuthenticatedAdmin(): Client
    {
        return $this->buildAuthentication(self::AUTHENTICATION_ADMIN_USERNAME);
    }


    /**
     * @param Client $client
     * @param string $url
     * @param array  $parameters
     * @param array  $groups
     */
    protected function buildGetRequest(Client $client, string $url, array $parameters = [], array $groups = []): void
    {
        if (empty($groups)) {
            $groups = ['test'];
        }

        $parameters['groups'] = implode(',', $groups);

        $client->request( 'GET', '/api/' . $url . '?' . http_build_query($parameters));
    }

    /**
     * @param Client $client
     * @param string $url
     * @param array  $formData
     */
    protected function buildPostRequest(Client $client, string  $url, array $formData = []): void
    {
        $client->request('POST', '/api/' . $url, $formData);
    }

    /**
     * @param Client $client
     * @param string $url
     * @param array  $formData
     */
    protected function buildPutRequest(Client $client, string $url, array $formData = []): void
    {
        $client->request('PUT', '/api/' . $url, $formData);
    }

    /**
     * @param Client $client
     * @param string $url
     */
    protected function buildDeleteRequest(Client $client, string $url): void
    {
        $client->request('DELETE', '/api/' . $url);
    }

    /**
     * @param string $filename
     *
     * @return array
     */
    protected function loadDataFromJsonFile(string $filename): array
    {
        return json_decode(file_get_contents('tests/Resources/' . $filename . '.json'), true);
    }

    /**
     * @param Client $client
     * @param string $className
     *
     * @return AbstractBaseRepository
     */
    protected function getDocumentRepository(Client $client, $className): AbstractBaseRepository
    {
        $manager = $client->getContainer()->get('doctrine')->getManager();

        return $manager->getRepository($className);
    }

    /**
     * @param string $username
     *
     * @return Client
     */
    private function buildAuthentication(string $username): Client
    {
        $authenticationClient = static::createClient();
        $this->buildPostRequest(
            $authenticationClient,
            'login_check',
            [
                'username' => $username,
                'password' => self::AUTHENTICATION_DEFAULT_PASSWORD
            ]
        );

        $response = $authenticationClient->getResponse();
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new AuthenticationException($response->getContent());
        }

        $data = json_decode($response->getContent(), true);

        return static::createClient(
            [],
            ['HTTP_Authorization' => self::AUTHORIZATION_HEADER_PREFIX . ' ' . $data['token']]
        );
    }
}
