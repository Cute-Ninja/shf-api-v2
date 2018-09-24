<?php

namespace App\Tests\Behat\Context;

use App\Entity\User\User;
use App\Tests\PHPUnit\Controller\ShfTestInterface;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class PageContext extends AbstractBaseContext
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Response|null
     */
    private $response;

    /**
     * @throws UnsupportedDriverActionException
     *
     * @Given I am an anonymous User
     */
    public function iAmAnAnonymousUser(): void
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('This step is only supported by the BrowserKitDriver', $driver);
        }
        
        $this->client = $driver->getClient();
    }

    /**
     * @throws UnsupportedDriverActionException
     *
     * @Given I am logged as Ghriim
     */
    public function iAmLoggedAsGhriim(): void
    {
        $this->buildAuthentication(ShfTestInterface::AUTHENTICATION_PERSONAL_USERNAME);
    }

    /**
     * @throws UnsupportedDriverActionException
     *
     * @Given I am logged as an Administrator
     */
    public function iAmLoggedAsAnAdministrator(): void
    {
        $this->buildAuthentication(ShfTestInterface::AUTHENTICATION_ADMIN_USERNAME);
    }

    /**
     * @param string $pageName
     *
     * @When I visit the page :pageName
     */
    public function iVisitThePage(string $pageName): void
    {
        $this->response = $this->visit($pageName);
    }

    /**
     * @Then a proper page should be displayed
     */
    public function thePageShouldBeDisplayed(): void
    {
        $this->assertResponseStatus(200);
    }

    /**
     * @param string $expectedTitle
     *
     * @throws \Exception
     *
     * @Then the title of the the page should be :expectedTitle
     */
    public function theTitleOfThePageShouldBe(string $expectedTitle): void
    {
        $actualTitle = $this->getSession()->getPage()->find('css', 'head title')->getText();
        if ($expectedTitle !== $actualTitle) {
            throw new \Exception("Page title is incorrect. Expected $expectedTitle and got $actualTitle");
        }
    }

    /**
     * @param string $username
     *
     * @throws UnsupportedDriverActionException
     */
    protected function buildAuthentication(string $username): void
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('This step is only supported by the BrowserKitDriver', $driver);
        }
        $this->client = $driver->getClient();

        $this->client->getCookieJar()->set(new Cookie(session_name(), true));

        $user = $this->getRepository($this->client, User::class)
                     ->findOneByCriteria(['username' => $username, 'status' => User::STATUS_ACTIVE]);

        if (null === $user) {
            throw new AuthenticationException('/!\ User could not be found for username ' . $username);
        }

        $session = $this->client->getContainer()->get('session');

        $token = new UsernamePasswordToken($user, null, 'secure_area', $user->getRoles());
        $session->set('_security_secured_area', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}