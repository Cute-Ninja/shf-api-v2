<?php

namespace App\Entity\Workout;

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