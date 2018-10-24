<?php

namespace App\Entity\Character;

use App\Entity\AbstractBaseEntity;
use App\Entity\User\User;
use Symfony\Component\Serializer\Annotation as Serializer;

class Character extends AbstractBaseEntity
{
    private const DEFAULT_LEVEL = 1;
    private const EXPERIENCE_FOR_LVL_2 = 1000;
    private const DEFAULT_ACTION_POINT = 5;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * Existing class: Warrior, Paladin, Assassin, Priest, Mage, Gunslinger
     *
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $class;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $level = self::DEFAULT_LEVEL;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $currentExperience = 0;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $nextLevelExperience = self::EXPERIENCE_FOR_LVL_2;


    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $currentActionPoint = self::DEFAULT_ACTION_POINT;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $maxActionPoint = self::DEFAULT_ACTION_POINT;


    /**
     * @var User
     */
    protected $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getCurrentExperience(): int
    {
        return $this->currentExperience;
    }

    /**
     * @param int $currentExperience
     */
    public function setCurrentExperience(int $currentExperience): void
    {
        $this->currentExperience = $currentExperience;
    }

    /**
     * @return int
     */
    public function getNextLevelExperience(): int
    {
        return $this->nextLevelExperience;
    }

    /**
     * @param int $nextLevelExperience
     */
    public function setNextLevelExperience(int $nextLevelExperience): void
    {
        $this->nextLevelExperience = $nextLevelExperience;
    }

    /**
     * @return int
     */
    public function getCurrentActionPoint(): int
    {
        return $this->currentActionPoint;
    }

    /**
     * @param int $currentActionPoint
     */
    public function setCurrentActionPoint(int $currentActionPoint): void
    {
        $this->currentActionPoint = $currentActionPoint;
    }

    /**
     * @return int
     */
    public function getMaxActionPoint(): int
    {
        return $this->maxActionPoint;
    }

    /**
     * @param int $maxActionPoint
     */
    public function setMaxActionPoint(int $maxActionPoint): void
    {
        $this->maxActionPoint = $maxActionPoint;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}