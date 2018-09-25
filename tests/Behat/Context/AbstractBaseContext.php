<?php

namespace App\Tests\Behat\Context;

use App\Repository\AbstractBaseRepository;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Process\Process;

abstract class AbstractBaseContext extends MinkContext implements SHFContextInterface
{
    /**
     * @AfterScenario @regenerateDB
     */
    public function regenerateDBBeforeScenario()
    {
        $process = new Process('make test_reset_db');
        $process->setTimeout(3600);
        $process->run();
    }

    /**
     * @Then access should not be authorized
     */
    public function accessShouldNotBeAuthorized(): void
    {
        $this->assertResponseStatus(401);
    }

    /**
     * @Then access should be forbidden
     */
    public function accessShouldBeForbidden(): void
    {
        $this->assertResponseStatus(403);
    }

    /**
     * @Then no result should be found
     */
    public function accessNotResultShouldBeFound(): void
    {
        $this->assertResponseStatus(404);
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