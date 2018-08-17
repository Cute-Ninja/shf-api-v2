<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class UserWorkout extends AbstractBaseEntity
{
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_OVERDUE   = 'overdue';
    public const STATUS_COMPLETED = 'completed';

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $scheduledDate;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $completionDate;

    /**
     * @var AbstractWorkout
     *
     * @Serializer\Groups({"workout", "test"})
     */
    protected $workout;

    /**
     * @var User
     *
     * @Serializer\Groups({"user"})
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
     * @return \DateTime|null
     */
    public function getScheduledDate(): ?\DateTime
    {
        return $this->scheduledDate;
    }

    /**
     * @param \DateTime $scheduledDate
     */
    public function setScheduledDate(\DateTime $scheduledDate): void
    {
        if ($this->isSchedulableStatus() && new \DateTime() < $scheduledDate) {
            $this->setStatus(self::STATUS_SCHEDULED);
        }
        $this->scheduledDate = $scheduledDate;
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
        $this->setStatus(self::STATUS_COMPLETED);
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
     * @return bool
     */
    public function isSchedulableStatus(): bool
    {
        $schedulableStatus = [
            self::STATUS_OVERDUE => self::STATUS_OVERDUE,
            self::STATUS_ACTIVE => self::STATUS_ACTIVE
        ];

        return isset($schedulableStatus[$this->getStatus()]);
    }
}