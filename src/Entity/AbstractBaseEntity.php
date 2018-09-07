<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

abstract class AbstractBaseEntity
{
    public const SERIALIZER_GROUP_DEFAULT = 'default';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DELETED = 'deleted';

    /**
     * @var string $status
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $status = self::STATUS_ACTIVE;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"lifecycle"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Serializer\Groups({"lifecycle"})
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function logCreate(): void
    {
        if (null === $this->createdAt) {
            $date = new \DateTime();
            $this->setCreatedAt($date);
            $this->setUpdatedAt($date);
        }
    }

    public function logUpdate(): void
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
