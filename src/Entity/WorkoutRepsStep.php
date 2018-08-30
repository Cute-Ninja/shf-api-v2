<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class WorkoutRepsStep extends AbstractWorkoutStep
{
    /**
     * @var int $numberOfRepetition
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $numberOfRepetition = 0;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_REPS;
    }

    /**
     * @return int
     */
    public function getNumberOfRepetition(): int
    {
        return $this->numberOfRepetition;
    }

    /**
     * @param int|null $numberOfRepetition
     */
    public function setNumberOfRepetition(?int $numberOfRepetition): void
    {
        $this->numberOfRepetition = $numberOfRepetition ?? 0;
    }
}