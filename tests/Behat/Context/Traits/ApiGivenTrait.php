<?php

namespace App\Tests\Behat\Context\Traits;

use App\Tests\PHPUnit\Controller\ShfTestInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

trait ApiGivenTrait
{
    abstract public function getSession($name = null);
    abstract public function request(string $method, string $apiName, array $parameters = []);

    /**
     * @Given I am an anonymous User
     */
    public function iAmAnAnonymousUser(): void
    {
        $this->getSession()->getDriver()->getClient()->setServerParameter('HTTP_Authorization', null);
    }

    /**
     * @Given I am logged as Ghriim
     */
    public function iAmLoggedAsGhriim(): void
    {
        $token = $this->buildAuthentication(ShfTestInterface::AUTHENTICATION_PERSONAL_USERNAME);
        $this->getSession()->getDriver()->getClient()->setServerParameter('HTTP_Authorization', "Bearer $token");
    }

    /**
     * @Given I am logged as an Administrator
     */
    public function iAmLoggedAsAnAdministrator(): void
    {
        $token = $this->buildAuthentication(ShfTestInterface::AUTHENTICATION_ADMIN_USERNAME);
        $this->getSession()->getDriver()->getClient()->setServerParameter('HTTP_Authorization', "Bearer $token");
    }

    /**
     * @param string $username
     *
     * @return string
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
}