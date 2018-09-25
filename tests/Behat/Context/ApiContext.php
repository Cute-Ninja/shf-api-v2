<?php

namespace App\Tests\Behat\Context;

use App\Tests\Behat\Context\Traits\ApiGivenTrait;
use App\Tests\Behat\Context\Traits\ApiThenTrait;
use App\Tests\Behat\Context\Traits\ApiWhenTrait;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Exception\UnsupportedDriverActionException;

class ApiContext extends AbstractBaseContext
{
    use ApiGivenTrait;
    use ApiWhenTrait;
    use ApiThenTrait;

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

        $client = $driver->getClient();
        $client->request(
            $method,
            "/api/$apiName?groups=test",
            $parameters
        );

        return $client->getResponse();
    }
}
