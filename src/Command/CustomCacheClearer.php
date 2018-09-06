<?php

namespace App\Command;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CustomCacheClearer extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('shf_api:cache:clear')
            ->setDescription('Custom clear cache');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $cache = new FilesystemAdapter();

        $cache->clear();
    }
}