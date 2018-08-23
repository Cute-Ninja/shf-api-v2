<?php

namespace App\Entity;

class ReferenceWorkout extends AbstractWorkout
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_REFERENCE;
    }
}