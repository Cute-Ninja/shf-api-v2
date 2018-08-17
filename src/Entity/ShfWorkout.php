<?php

namespace App\Entity;

class ShfWorkout extends AbstractWorkout
{
    public const WORKOUT_SOURCE_SHF = 'shf';

    /**
     * @return string
     */
    public function getSource(): string
    {
        return self::WORKOUT_SOURCE_SHF;
    }
}