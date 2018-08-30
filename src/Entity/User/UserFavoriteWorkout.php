<?php

namespace App\Entity\User;

use App\Entity\AbstractBaseEntity;
use App\Entity\Workout\AbstractWorkout;
use Symfony\Component\Serializer\Annotation as Serializer;

class UserFavoriteWorkout extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var AbstractWorkout
     *
     * @Serializer\Groups({"default", "test"})
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
     * @return AbstractWorkout|null
     */
    public function getWorkout(): ?AbstractWorkout
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
     * @return User|null
     */
    public function getUser(): ?User
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