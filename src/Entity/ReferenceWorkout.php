<?php

namespace App\Entity;

class ReferenceWorkout extends AbstractWorkout
{
    public const TYPE_REFERENCE = 'reference';

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_REFERENCE;
    }
}