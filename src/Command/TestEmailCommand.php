<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestEmailCommand extends Command
{
    /**
     * @var \Swift_Mailer
     */
    protected $swiftMailer;

    public function __construct(?string $name = 'shf_api:email:test', \Swift_Mailer $swiftMailer)
    {
        parent::__construct($name);

        $this->swiftMailer = $swiftMailer;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $email = new \Swift_Message();
        $email->setFrom('notification@superherofactory.com', 'Super Hero Factory')
              ->setTo('vignierquentin@yahoo.fr')
              ->setSubject('[SHF] Test email sending')
              ->setContentType('text/html')
              ->setBody(
                  '<div>This is a test !</div>'
              );

        $output->write('Test command has send: ' . $this->swiftMailer->send($email) . ' emails');
    }
}