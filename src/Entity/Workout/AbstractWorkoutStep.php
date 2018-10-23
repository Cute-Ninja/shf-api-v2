<?php

namespace App\Entity\Workout;

use App\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation as Serializer;

abstract class AbstractWorkoutStep extends AbstractBaseEntity
{
    public const STATUS_STARTED = 'started';
    public const STATUS_DONE    = 'done';

    public const TYPE_REST     = 'rest';
    public const TYPE_DISTANCE = 'distance';
    public const TYPE_DURATION = 'duration';
    public const TYPE_AMRAP    = 'amrap';
    public const TYPE_REPS     = 'reps';

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var int $position
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $position;

    /**
     * @var int $estimatedDuration (in seconds)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $estimatedDuration;

    /**
     * @var \DateTime $startingDate
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $startingDate;

    /**
     * @var \DateTime $startingDate
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $completionDate;

    /**
     * @var AbstractWorkout $workout
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $workout;

    /**
     * @var Exercise $exercise
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $exercise;

    /**
     * @return string
     *
     * @Serializer\Groups({"default", "test"})
     */
    abstract public function getType(): string;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int|null
     */
    public function getEstimatedDuration(): ?int
    {
        return $this->estimatedDuration;
    }

    /**
     * @param int $estimatedDuration
     */
    public function setEstimatedDuration(int $estimatedDuration): void
    {
        $workoutDuration = $this->getWorkout()->getEstimatedDuration();
        $this->getWorkout()->setEstimatedDuration($workoutDuration - $this->estimatedDuration + $estimatedDuration);

        $this->estimatedDuration = $estimatedDuration;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartingDate(): ?\DateTime
    {
        return $this->startingDate;
    }

    /**
     * @param \DateTime|null $startingDate
     */
    public function setStartingDate(?\DateTime $startingDate): void
    {
        if (null !== $startingDate) {
            $this->setStatus(self::STATUS_STARTED);
        } else {
            $this->setStatus(self::STATUS_ACTIVE);
        }

        $this->startingDate = $startingDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getCompletionDate(): ?\DateTime
    {
        return $this->completionDate;
    }

    /**
     * @param \DateTime|null $completionDate
     */
    public function setCompletionDate(?\DateTime $completionDate): void
    {
        if (null !== $completionDate) {
            $this->setStatus(self::STATUS_DONE);
        } elseif (null !== $this->getStartingDate()) {
            $this->setStatus(self::STATUS_STARTED);
        } else {
            $this->setStatus(self::STATUS_ACTIVE);
        }

        $this->completionDate = $completionDate;
    }

    /**
     * @return AbstractWorkout
     */
    public function getWorkout(): AbstractWorkout
    {
        return $this->workout;
    }

    /**
     * @param AbstractWorkout $workout
     */
    public function setWorkout(AbstractWorkout $workout): void
    {
        $this->workout = $workout;
    }

    /**
     * @return Exercise|null
     */
    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     */
    public function setExercise(Exercise $exercise): void
    {
        $this->exercise = $exercise;
    }
}