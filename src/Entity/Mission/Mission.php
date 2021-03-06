<?php

namespace App\Entity\Mission;

use App\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation as Serializer;

class Mission extends AbstractBaseEntity
{
    public const PERIODICITY_DAILY  = 'daily';
    public const PERIODICITY_WEEKLY = 'weekly';
    public const PERIODICITY_ON_OFF = 'on-off';

    public const WATER_TRACKER_DAILY_MISSION_ID = 1;
    public const FAVORITES_WORKOUT_MISSION_ID = 9;

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
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $description;

    /**
     * @var integer
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $objective;

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
    protected $periodicity;

    /**
     * @var bool
     */
    protected $autoCalculated = true;

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
     * @return string|
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getObjective(): ?int
    {
        return $this->objective;
    }

    /**
     * @param int $objective
     */
    public function setObjective(int $objective): void
    {
        $this->objective = $objective;
    }

    /**
     * @return int
     */
    public function getExperience(): int
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
     * @return string
     */
    public function getPeriodicity(): string
    {
        return $this->periodicity;
    }

    /**
     * @param string $periodicity
     */
    public function setPeriodicity(string $periodicity): void
    {
        $this->periodicity = $periodicity;
    }

    /**
     * @return bool
     */
    public function isAutoCalculated(): bool
    {
        return $this->autoCalculated;
    }

    /**
     * @param bool $autoCalculated
     */
    public function setAutoCalculated(bool $autoCalculated): void
    {
        $this->autoCalculated = $autoCalculated;
    }
}