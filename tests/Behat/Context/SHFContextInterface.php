<?php

namespace App\Tests\Behat\Context;

interface SHFContextInterface
{
    public function iAmAnAnonymousUser(): void;

    public function iAmLoggedAsGhriim(): void;

    public function iAmLoggedAsAnAdministrator(): void;
}