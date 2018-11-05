<?php

namespace App\Entity\Character;

use App\Entity\AbstractBaseEntity;
use App\Entity\User\User;
use Symfony\Component\Serializer\Annotation as Serializer;

class Character extends AbstractBaseEntity
{
    private const DEFAULT_LEVEL = 1;
    private const DEFAULT_LEVEL_EXPERIENCE = 1000;
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
    protected $nextLevelExperience = self::DEFAULT_LEVEL_EXPERIENCE;


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
     * Character constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
     * @return int
     */
    public function getCurrentExperience(): int
    {
        return $this->currentExperience;
    }

    /**
     * @return int
     */
    public function getNextLevelExperience(): int
    {
        return $this->nextLevelExperience;
    }

    /**
     * @return int
     */
    public function getCurrentActionPoint(): int
    {
        return $this->currentActionPoint;
    }

    /**
     * @return int
     */
    public function getMaxActionPoint(): int
    {
        return $this->maxActionPoint;
    }

    /**
     * @return Character
     */
    public function levelUp(): Character
    {
        $this->level = $this->getLevel() + 1;
        $this->maxActionPoint = $this->calculateMaxActionPoint();
        $this->nextLevelExperience = $this->calculateNextLevelExperience();

        return $this;
    }

    /**
     * @param int $experience
     *
     * @return Character
     */
    public function earnExperience(int $experience): Character
    {
        $this->currentExperience = $this->getCurrentExperience() + $experience;
        if ($this->getCurrentExperience() >= $this->getNextLevelExperience()) {
            $this->levelUp();
        }

        return $this;
    }

    /**
     * @param int $actionPoint
     *
     * @return int
     */
    public function spendActionPoint(int $actionPoint): int
    {
        $this->currentActionPoint = $this->getCurrentActionPoint() - $actionPoint;

        return $this->getCurrentActionPoint();
    }

    /**
     * @param int $actionPoint
     *
     * @return int
     */
    public function earnActionPoint(int $actionPoint): int
    {
        $this->currentActionPoint = $this->getCurrentActionPoint() + $actionPoint;

        return $this->getCurrentActionPoint();
    }

    /**
     * @return int
     */
    protected function calculateNextLevelExperience(): int
    {
        $nextLevelXP =  ($this->getLevel() * self::DEFAULT_LEVEL_EXPERIENCE) * 1.5;

        return $this->getNextLevelExperience() + $nextLevelXP;
    }

    /**
     * Earn 1 ActionPoint every other level
     *
     * @return int
     */
    protected function calculateMaxActionPoint(): int
    {
        $addMaxActionPoint = ($this->getLevel() % 2) === 0 ? 1 : 0;

        return $this->getMaxActionPoint() + $addMaxActionPoint;
    }
}