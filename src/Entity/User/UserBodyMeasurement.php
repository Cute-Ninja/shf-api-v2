<?php

namespace App\Entity\User;

use Symfony\Component\Serializer\Annotation as Serializer;

class UserBodyMeasurement extends AbstractBodyMeasurement
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;
}