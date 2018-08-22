<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation as Serializer;

abstract class AbstractWorkout extends AbstractBaseEntity
{
    public const WORKOUT_SOURCE_SHF = 'shf';
    public const WORKOUT_SOURCE_COMMUNITY = 'community';


    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $name;

    /**
     * @var int (value between 1 and 10)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $difficulty;

    /**
     * @var int (in seconds)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $duration;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $calories;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $experience;

    /**
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $source;

    /**
     * @var User
     *
     * @Serializer\Groups({"creator"})
     */
    protected $creator;

    /**
     * @var AbstractWorkoutStep[]
     *
     * @Serializer\Groups({"steps"})
     */
    protected $workoutSteps;

    /**
     * @deprecated since 17/08/2018
     *
     * Used for serialization only
     *
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $favoriteId;

    /**
     * @return string
     */
    abstract public function getType(): string;

    public function __construct()
    {
        $this->workoutSteps = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    /**
     * @param int $difficulty
     */
    public function setDifficulty(int $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
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

    /**
     * @return int|null
     */
    public function getCalories(): ?int
    {
        return $this->calories;
    }

    /**
     * @param int $calories
     */
    public function setCalories(int $calories): void
    {
        $this->calories = $calories;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * @return int|null
     */
    public function getExperience(): ?int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }

    /**
     * @return AbstractWorkoutStep[]|ArrayCollection|array
     */
    public function getWorkoutSteps()
    {
        return $this->workoutSteps;
    }

    /**
     * @param AbstractWorkoutStep[]|ArrayCollection|array $workoutSteps
     */
    public function setWorkoutSteps($workoutSteps): void
    {
        $this->workoutSteps = $workoutSteps;
    }

    /**
     * @deprecated since 17/08/2018
     *
     * @return int
     */
    public function getFavoriteId(): ?int
    {
        return $this->favoriteId;
    }

    /**
     * @deprecated since 17/08/2018
     *
     * @param int $favoriteId
     */
    public function setFavoriteId(int $favoriteId): void
    {
        $this->favoriteId = $favoriteId;
    }
}