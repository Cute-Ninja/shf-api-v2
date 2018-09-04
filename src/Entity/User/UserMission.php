<?php

namespace App\Entity\User;

use App\Entity\Mission\Mission;

class UserMission
{
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
     * @param int $current
     */
    public function setCurrent(int $current): void
    {
        $this->current = $current;
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
}