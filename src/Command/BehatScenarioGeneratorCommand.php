<?php

namespace App\Command;

use App\Utils\StringUtils;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class BehatScenarioGeneratorCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('shf_api:test_behat:scenario_generator')
             ->setDescription('Auto generate default behat scenario for a given API')
             ->addArgument('url', InputArgument::REQUIRED, 'The url of the API')
             ->addOption('entity', null, InputOption::VALUE_OPTIONAL, 'The folder that will contain the test if not guessable');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $apiUrl     = $input->getArgument('url');
        $entityName = $input->getOption('entity');

        if (null === $entityName) {
            $entityName = $this->guessEntityName($apiUrl);
        }

        $folderPath = "tests/Behat/Features/Api/$entityName";
        if (true === $this->generateFolder($output, $folderPath)) {
            $this->generateScenarioFiles($entityName, $folderPath);
        }
    }

    /**
     * @param OutputInterface $output
     * @param string          $folderPath
     *
     * @return bool
     */
    private function generateFolder(OutputInterface $output, string $folderPath): bool
    {
        $fileSystem = new Filesystem();
        if ($fileSystem->exists($folderPath)) {
            $output->writeln("<error>Looks like this API already has scenario in $folderPath</error>");

            return false;
        }

        $fileSystem->mkdir($folderPath);

        $output->writeln("<info>Scenario successfully generated in $folderPath</info>");

        return true;
    }

    /**
     * @param string $entityName
     * @param string $folderPath
     */
    private function generateScenarioFiles(string $entityName, string $folderPath): void
    {
        $entityName = lcfirst($entityName);

        $fileSystem = new Filesystem();
        $fileSystem->touch("$folderPath/getOne-$entityName.feature");
        $fileSystem->touch("$folderPath/getMany-$entityName.feature");
        $fileSystem->touch("$folderPath/post-$entityName.feature");
        $fileSystem->touch("$folderPath/put-$entityName.feature");
        $fileSystem->touch("$folderPath/delete-$entityName.feature");
    }

    /**
     * @param string $apiUrl
     *
     * @return string
     */
    private function guessEntityName(string  $apiUrl): string
    {
        $apiName = explode('/', $apiUrl)[0];
        if (in_array($apiName, ['api', 'front', 'admin'])) {
            throw new RuntimeCommandException('Parameter url should contain generic part of url (ex: favorite-workouts or workouts/{workoutId}/steps})');
        }

        return StringUtils::singularize(StringUtils::dashesToCamelCase($apiName));
    }
}