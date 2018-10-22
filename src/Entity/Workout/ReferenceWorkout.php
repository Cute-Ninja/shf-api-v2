<?php

namespace App\Entity\Workout;

class ReferenceWorkout extends AbstractWorkout
{
    /**
     * @var bool
     */
    protected $standAlone = true;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_REFERENCE;
    }

    /**
     * @return bool
     */
    public function isStandAlone(): bool
    {
        return $this->standAlone;
    }

    /**
     * @param bool $standAlone
     */
    public function setStandAlone(bool $standAlone): void
    {
        $this->standAlone = $standAlone;
    }
}