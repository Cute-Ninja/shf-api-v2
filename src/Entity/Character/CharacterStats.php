<?php

namespace App\Entity\Character;

use App\Entity\AbstractBaseEntity;
use App\Entity\User\User;
use Symfony\Component\Serializer\Annotation as Serializer;

class CharacterStats extends AbstractBaseEntity
{
    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $id;

    /**
     * Define the physical damage and the weapon/armor you can carry
     *
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $strength;

    /**
     * Define the maxHP and HP regeneration speed
     *
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $constitution;

    /**
     * Define speed and critical rate
     *
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $agility;

    /**
     * Define the magical damage and the spell you can learn
     *
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $intelligence;

    /**
     * Define the maxMP and MP regeneration speed
     *
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $wisdom;



    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $currentHP;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $maxHP;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $currentMP;

    /**
     * @var int
     *
     * @Serializer\Groups({"default", "test"})
     */
    protected $maxMP;


    /**
     * @var Character
     */
    protected $character;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    /**
     * @param int $strength
     */
    public function setStrength(int $strength): void
    {
        $this->strength = $strength;
    }

    /**
     * @return int
     */
    public function getConstitution(): int
    {
        return $this->constitution;
    }

    /**
     * @param int $constitution
     */
    public function setConstitution(int $constitution): void
    {
        $this->constitution = $constitution;
    }

    /**
     * @return int
     */
    public function getAgility(): int
    {
        return $this->agility;
    }

    /**
     * @param int $agility
     */
    public function setAgility(int $agility): void
    {
        $this->agility = $agility;
    }

    /**
     * @return int
     */
    public function getIntelligence(): int
    {
        return $this->intelligence;
    }

    /**
     * @param int $intelligence
     */
    public function setIntelligence(int $intelligence): void
    {
        $this->intelligence = $intelligence;
    }

    /**
     * @return int
     */
    public function getWisdom(): int
    {
        return $this->wisdom;
    }

    /**
     * @param int $wisdom
     */
    public function setWisdom(int $wisdom): void
    {
        $this->wisdom = $wisdom;
    }

    /**
     * @return int
     */
    public function getCurrentHP(): int
    {
        return $this->currentHP;
    }

    /**
     * @param int $currentHP
     */
    public function setCurrentHP(int $currentHP): void
    {
        $this->currentHP = $currentHP;
    }

    /**
     * @return int
     */
    public function getMaxHP(): int
    {
        return $this->maxHP;
    }

    /**
     * @param int $maxHP
     */
    public function setMaxHP(int $maxHP): void
    {
        $this->maxHP = $maxHP;
    }

    /**
     * @return int
     */
    public function getCurrentMP(): int
    {
        return $this->currentMP;
    }

    /**
     * @param int $currentMP
     */
    public function setCurrentMP(int $currentMP): void
    {
        $this->currentMP = $currentMP;
    }

    /**
     * @return int
     */
    public function getMaxMP(): int
    {
        return $this->maxMP;
    }

    /**
     * @param int $maxMP
     */
    public function setMaxMP(int $maxMP): void
    {
        $this->maxMP = $maxMP;
    }

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @param Character $character
     */
    public function setCharacter(Character $character): void
    {
        $this->character = $character;
    }
}