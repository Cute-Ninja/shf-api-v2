<?php

namespace App\Entity\Workout;

use App\Entity\AbstractBaseEntity;
use Symfony\Component\Serializer\Annotation as Serializer;

class Exercise extends AbstractBaseEntity
{
    public const TYPE_REST       = 'rest';
    public const TYPE_REPETITION = 'repetition';
    public const TYPE_DISTANCE   = 'distance';
    public const TYPE_DURATION   = 'duration';
    public const TYPE_HOLD       = 'hold';

    private const COVER_DEFAULT = 'http://via.placeholder.com/200x150';

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
     * @var string $type
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $type;

    /**
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $cover = self::COVER_DEFAULT;

    /**
     * @var string
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $videoLink;

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
     * @return string
     */
    public function getCover(): string
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover(string $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return string|null
     */
    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    /**
     * @param  string|null
     */
    public function setVideoLink(?string $videoLink): void
    {
        $this->videoLink = $videoLink;
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