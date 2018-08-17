<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class WaterTrackerEntry extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default"})
     */
    protected $id;

    /**
     * @var int (in mL)
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $quantity;

    /**
     * @var WaterTracker
     */
    protected $tracker;

    public function __construct(WaterTracker $tracker)
    {
        $this->setTracker($tracker);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return WaterTracker
     */
    public function getTracker(): WaterTracker
    {
        return $this->tracker;
    }

    /**
     * @param WaterTracker $tracker
     */
    public function setTracker(WaterTracker $tracker): void
    {
        $this->tracker = $tracker;
    }

    /**
     * Required for serialization purpose
     *
     * @return \DateTime
     *
     * @Serializer\Groups({"default"})
     */
    public function getCreatedAt(): \DateTime
    {
        return parent::getCreatedAt();
    }
}