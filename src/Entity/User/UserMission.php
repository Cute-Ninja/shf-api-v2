<?php

namespace App\Entity\User;

use App\Entity\AbstractBaseEntity;
use App\Entity\Mission\Mission;
use App\Utils\Clock;
use Symfony\Component\Serializer\Annotation as Serializer;

class UserMission extends AbstractBaseEntity
{
    public const STATUS_COMPLETED = 'completed';

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $current;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $objective;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $completionDate;

    /**
     * @var Mission
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $mission;

    /**
     * @var User
     *
     * @Serializer\Groups({"user"})
     */
    protected $user;

    /**
     * UserMission constructor.
     *
     * @param User    $user
     * @param Mission $mission
     */
    public function __construct(User $user, Mission $mission)
    {
        $this->setUser($user);
        $this->setMission($mission);
        $this->setObjective($mission->getObjective());
    }

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
    public function getCurrent(): ?int
    {
        return $this->current;
    }

    /**
     * @param int|null $current
     */
    public function setCurrent(?int $current): void
    {
        $this->current = $current;

        if ($this->getCurrent() >= $this->getObjective()) {
            $this->setStatus(self::STATUS_COMPLETED);
        }
    }

    /**
     * @param int|null $incrementValue
     */
    public function incrementCurrent(?int $incrementValue): void
    {
        if (null === $incrementValue && null === $this->getCurrent()) {
            $this->setCurrent(null);
        } else {
            $this->setCurrent($this->getCurrent() + $incrementValue);
        }
    }

    /**
     * @return int|null
     */
    public function getObjective(): ?int
    {
        return $this->objective;
    }

    /**
     * @param int|null $objective
     */
    public function setObjective(?int $objective): void
    {
        $this->objective = $objective;
    }

    /**
     * @return \DateTime|null
     */
    public function getCompletionDate(): ?\DateTime
    {
        return $this->completionDate;
    }

    /**
     * @param \DateTime $completionDate
     */
    public function setCompletionDate(\DateTime $completionDate): void
    {
        $this->completionDate = $completionDate;

        $this->setStatus(self::STATUS_COMPLETED);
    }

    /**
     * @return Mission
     */
    public function getMission(): Mission
    {
        return $this->mission;
    }

    /**
     * @param Mission $mission
     */
    public function setMission(Mission $mission): void
    {
        $this->mission = $mission;
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

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        if (self::STATUS_COMPLETED === $status && null === $this->getCompletionDate()) {
            $this->setCompletionDate(Clock::now());
        }

        parent::setStatus($status);
    }
}