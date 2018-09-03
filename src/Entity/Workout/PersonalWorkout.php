<?php

namespace App\Entity\Workout;

use App\Entity\User\User;
use App\Utils\DateUtils;
use Symfony\Component\Serializer\Annotation as Serializer;

class PersonalWorkout extends AbstractWorkout
{

    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_OVERDUE   = 'overdue';
    public const STATUS_COMPLETED = 'completed';

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
     * @var User
     *
     * @Serializer\Groups({"owner", "test"})
     */
    protected $owner;

    /**
     * @var ReferenceWorkout
     *
     * @Serializer\Groups({"reference"})
     */
    protected $referenceWorkout;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_PERSONAL;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        if (self::STATUS_ACTIVE === $status) {
            $scheduledDate = $this->getScheduledDate();
            if (null !== $scheduledDate && false === DateUtils::isPassed($scheduledDate)) {
                $status = self::STATUS_SCHEDULED;
            } elseif (null !== $scheduledDate && true === DateUtils::isPassed($scheduledDate)) {
                $status = self::STATUS_OVERDUE;
            }
        }

        parent::setStatus($status);
    }

    /**
     * @return \DateTime
     */
    public function getScheduledDate(): ?\DateTime
    {
        return $this->scheduledDate;
    }

    /**
     * @param \DateTime|null $scheduledDate
     */
    public function setScheduledDate(?\DateTime $scheduledDate): void
    {
        if ($this->isSchedulableStatus() && new \DateTime() < $scheduledDate) {
            $this->setStatus(self::STATUS_SCHEDULED);
        }

        $this->scheduledDate = $scheduledDate;
    }

    /**
     * @return \DateTime
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
     * @return User
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return ReferenceWorkout|null
     */
    public function getReferenceWorkout(): ?ReferenceWorkout
    {
        return $this->referenceWorkout;
    }

    /**
     * @param ReferenceWorkout $referenceWorkout
     */
    public function setReferenceWorkout(ReferenceWorkout $referenceWorkout): void
    {
        $this->referenceWorkout = $referenceWorkout;
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