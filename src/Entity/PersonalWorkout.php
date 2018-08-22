<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class PersonalWorkout extends AbstractWorkout
{
    public const TYPE_PERSONAL = 'personal';

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
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_PERSONAL;
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
    public function setScheduledDate($scheduledDate): void
    {
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
     * @param \DateTime|null $completionDate
     */
    public function setCompletionDate($completionDate): void
    {
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
}