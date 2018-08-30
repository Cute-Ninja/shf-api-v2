<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

abstract class AbstractWorkoutStep extends AbstractBaseEntity
{
    public const STATUS_DONE = 'done';

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
        try {
        $workoutDuration = $this->getWorkout()->getEstimatedDuration();
        $this->getWorkout()->setEstimatedDuration($workoutDuration - $this->estimatedDuration + $estimatedDuration);
        } catch (\Exception $e) {
            var_dump([$this->getId(), $this->getType()]); die;
        }

        $this->estimatedDuration = $estimatedDuration;
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