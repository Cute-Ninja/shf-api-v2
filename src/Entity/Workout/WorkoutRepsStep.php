<?php

namespace App\Entity\Workout;

use Symfony\Component\Serializer\Annotation as Serializer;

class WorkoutRepsStep extends AbstractWorkoutStep
{
    /**
     * @var int $repsPlanned
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $repsPlanned = 0;

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
    public function getRepsPlanned(): int
    {
        return $this->repsPlanned;
    }

    /**
     * @param int $repsPlanned
     */
    public function setRepsPlanned(int $repsPlanned): void
    {
        $this->repsPlanned = $repsPlanned ?? 0;
    }
}