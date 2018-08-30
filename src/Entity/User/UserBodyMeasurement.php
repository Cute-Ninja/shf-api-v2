<?php

namespace App\Entity\User;

use App\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation as Serializer;

class UserBodyMeasurement extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * @var int (in centimeters)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $height;

    /**
     * @var int (in grammes)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $weight;

    /**
     * @var int (in bpm)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $restingHeartRate;

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
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getRestingHeartRate()
    {
        return $this->restingHeartRate;
    }

    /**
     * @param mixed $restingHeartRate
     */
    public function setRestingHeartRate($restingHeartRate): void
    {
        $this->restingHeartRate = $restingHeartRate;
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