<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class WorkoutDurationStep extends AbstractWorkoutStep
{
    /**
     * @var int $duration
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $duration;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_DURATION;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }
}