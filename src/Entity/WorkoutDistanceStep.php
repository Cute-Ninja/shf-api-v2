<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class WorkoutDistanceStep extends AbstractWorkoutStep
{
    /**
     * @var int $distance
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $distance;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_DISTANCE;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     */
    public function setDistance(int $distance): void
    {
        $this->distance = $distance;
    }
}