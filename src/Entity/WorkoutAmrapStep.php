<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class WorkoutAmrapStep extends AbstractWorkoutStep
{
    /**
     * @var int $duration
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $duration = 0;

    /**
     * @var integer $repsDone
     */
    protected $repsDone = 0;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_AMRAP;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int| $duration
     */
    public function setDuration(?int $duration): void
    {
        $this->duration = $duration ?? 0;
    }

    /**
     * @return int
     */
    public function getRepsDone(): int
    {
        return $this->repsDone;
    }

    /**
     * @param int $repsDone
     */
    public function setRepsDone(int $repsDone): void
    {
        $this->repsDone = $repsDone ?? 0;
    }
}