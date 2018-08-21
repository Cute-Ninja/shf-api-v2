<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class Exercise extends AbstractBaseEntity
{
    public const TYPE_REST       = 'rest';
    public const TYPE_REPETITION = 'repetition';
    public const TYPE_DISTANCE   = 'distance';
    public const TYPE_DURATION   = 'duration';
    public const TYPE_HOLD       = 'hold';

    /**
     * @var int
     *
     * @Serializer\Groups({"default"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"default"})
     */
    protected $name;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var Equipment[]
     */
    protected $equipments = [];

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Equipment[]
     */
    public function getEquipments(): array
    {
        return $this->equipments;
    }

    /**
     * @param Equipment[] $equipments
     */
    public function setEquipments(array $equipments): void
    {
        $this->equipments = $equipments;
    }
}