<?php

namespace App\Domain\Persister;

use Doctrine\Common\Persistence\ObjectManager;

abstract class AbstractPersister
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}