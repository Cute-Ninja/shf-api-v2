<?php

namespace App\tests\Behat\Context;

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
        $this->visit("api/$apiName/$id?groups=test");
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
     * @param string $fileName
     *
     * @throws \Exception
     *
     * @Then the content should be similar to :fileName
     */
    public function contentShouldBeSimilarTo(string $fileName): void
    {
        $result = new Json($this->getSession()->getDriver()->getContent());

        $expected = $this->loadDataFromJsonFile($fileName);
        $actual   = json_decode($result->encode(), true);
        if ($expected !== $actual) {
            $message = "The result are not equals. \n";
            $message .= 'Expected:' . print_r($this->arrayRecursiveDiff($expected, $actual), true);
            $message .= 'Actual:'   . print_r($this->arrayRecursiveDiff($actual, $expected), true);

            throw new \Exception($message);
        }
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

    /**
     * @param string $filename
     *
     * @return array
     */
    protected function loadDataFromJsonFile(string $filename): array
    {
        return json_decode(file_get_contents('tests/Resources/json/' . $filename), true);
    }

    /**
     * @param $array1
     * @param $array2
     *
     * @return array
     */
    public function arrayRecursiveDiff(array $aArray1, array $aArray2): array
    {
        $aReturn = [];
        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = $this->arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue !== $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }
        return $aReturn;
    }
}
