<?php

namespace App\Entity\Workout;

use App\Entity\AbstractBaseEntity;
use App\Entity\User\User;
use Symfony\Component\Serializer\Annotation as Serializer;

abstract class AbstractWorkout extends AbstractBaseEntity
{
    public const WORKOUT_SOURCE_SHF = 'shf';
    public const WORKOUT_SOURCE_COMMUNITY = 'community';

    public const TYPE_REFERENCE = 'reference';
    public const TYPE_PERSONAL = 'personal';

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
    protected $estimatedDuration;

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
     * @return string|null
     */
    public function getName(): ?string
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
    public function getEstimatedDuration(): ?int
    {
        return $this->estimatedDuration;
    }

    /**
     * @param int $estimatedDuration
     */
    public function setEstimatedDuration(int $estimatedDuration): void
    {
        $this->estimatedDuration = $estimatedDuration;
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
     * @return string|null
     */
    public function getSource(): ?string
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