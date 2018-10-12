<?php

namespace App\Domain\Manager;

use App\Entity\User\User;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Yaml\Yaml;

class EmailManager
{
    /**
     * @var \Swift_Mailer
     */
    protected $swiftMailer;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param \Swift_Mailer       $swiftMailer
     * @param EngineInterface     $templating
     * @param TranslatorInterface $translator
     */
    public function __construct(
        \Swift_Mailer $swiftMailer,
        EngineInterface $templating,
        TranslatorInterface $translator
    )
    {
        $this->swiftMailer = $swiftMailer;
        $this->templating  = $templating;
        $this->translator  = $translator;
    }

    /**
     * @param User   $user
     * @param string $configFileName
     * @param array  $parameters
     *
     * @return bool
     */
    public function sendEmailToUser(User $user, string $configFileName, array $parameters = []): bool
    {
        $config = Yaml::parseFile(__DIR__ . "/../../../config/email/$configFileName.yaml")['configuration'];

        $email = new \Swift_Message();
        $email->setFrom($config['sender']['email'], $config['sender']['name'])
              ->setTo($user->getEmail())
              ->setSubject($this->translator->trans($config['subject'], [], 'email'))
              ->setContentType('text/html')
              ->setBody(
                  $this->templating->render(
                      $config['template'],
                      $this->addDefaultParameters($user, $parameters)
                  )
              );

        return $this->swiftMailer->send($email) > 0;
    }

    /**
     * @param User  $user
     * @param array $parameters
     *
     * @return array
     */
    protected function addDefaultParameters(User $user, array $parameters = []): array
    {
        $parameters['username'] = $user->getUsername();

        return $parameters;
    }
}