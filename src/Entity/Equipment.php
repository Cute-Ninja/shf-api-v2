<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class Equipment extends AbstractBaseEntity
{
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
}