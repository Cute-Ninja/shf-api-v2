<?php

namespace App\Tests\Behat\Context;

use App\Tests\PHPUnit\Controller\ShfTestInterface;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behatch\Json\Json;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ApiContext extends AbstractBaseContext
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @Given I am an anonymous User
     */
    public function iAmAnAnonymousUser(): void
    {
        // Do nothing
    }

    /**
     * @throws UnsupportedDriverActionException
     *
     * @Given I am logged as Ghriim
     */
    public function iAmLoggedAsGhriim(): void
    {
        $token = $this->buildAuthentication(ShfTestInterface::AUTHENTICATION_PERSONAL_USERNAME);
        $this->getSession()->setRequestHeader('Authorization', "Bearer $token");
    }

    /**
     * @throws UnsupportedDriverActionException
     *
     * @Given I am logged as an Administrator
     */
    public function iAmLoggedAsAnAdministrator(): void
    {
        $token = $this->buildAuthentication(ShfTestInterface::AUTHENTICATION_ADMIN_USERNAME);
        $this->getSession()->setRequestHeader('Authorization', "Bearer $token");
    }

    /**
     * @param string     $apiName
     * @param string|int $id
     *
     * @When I request the api :apiName with id :id
     */
    public function iRequestTheApiWithId(string $apiName, $id): void
    {
        $this->visit("api/$apiName/$id");
    }

    /**
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     *
     * @Then a proper response should be return
     */
    public function aProperResponseShouldBeReturned(): void
    {
        $this->assertResponseStatus(200);
        new Json($this->getSession()->getDriver()->getContent());
    }

    /**
     * @param string $username
     *
     * @return string
     * @throws UnsupportedDriverActionException
     */
    protected function buildAuthentication(string $username): string
    {
        $response = $this->request(
            'POST',
            'login_check',
            [
                'username' => $username,
                'password' => ShfTestInterface::AUTHENTICATION_DEFAULT_PASSWORD
            ]
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new AuthenticationException($response->getContent());
        }

        return json_decode($response->getContent(), true)['token'];
    }

    /**
     * @param string $method
     * @param string $apiName
     * @param array  $parameters
     *
     * @return object
     * @throws UnsupportedDriverActionException
     */
    protected function request(string $method, string $apiName, array $parameters = [])
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('This step is only supported by the BrowserKitDriver', $driver);
        }

        $authenticationClient = $driver->getClient();
        $authenticationClient->request(
            $method,
            "api/$apiName",
            $parameters
        );

        return $authenticationClient->getResponse();
    }
}