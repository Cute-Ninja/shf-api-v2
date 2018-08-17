<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class UserEquipment extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default"})
     */
    protected $id;

    /**
     * @var Equipment
     *
     * @Serializer\Groups({"default"})
     */
    protected $equipment;

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
     * @return Equipment
     */
    public function getEquipment(): Equipment
    {
        return $this->equipment;
    }

    /**
     * @param Equipment $equipment
     */
    public function setEquipment(Equipment $equipment): void
    {
        $this->equipment = $equipment;
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