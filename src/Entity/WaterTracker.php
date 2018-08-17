<?php

namespace App\Entity;

use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Annotation as Serializer;

class WaterTracker extends AbstractBaseEntity
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
    protected $target;

    /**
     * @var WaterTrackerEntry[]
     *
     * @Serializer\Groups({"tracker-entries", "test"})
     */
    protected $entries = [];

    /**
     * @var User
     *
     * @Serializer\Groups({"tracker-user"})
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
     * @return int
     */
    public function getTarget(): int
    {
        return $this->target;
    }

    /**
     * @param int $target
     */
    public function setTarget(int $target): void
    {
        $this->target = $target;
    }

    /**
     * @return PersistentCollection|WaterTrackerEntry[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param WaterTrackerEntry[] $entries
     */
    public function setEntries(array $entries): void
    {
        $this->entries = $entries;
    }

    /**
     * @param WaterTrackerEntry $entry
     */
    public function addEntry(WaterTrackerEntry $entry): void
    {
        $this->entries[] = $entry;
    }

    /**
     * @param string $entryId
     *
     * @return bool
     */
    public function removeEntry($entryId): bool
    {
        foreach ($this->entries as $index => $entry) {
            if ($entryId === $entry->getId()) {
                unset($this->entries[$index]);

                return true;
            }
        }

        return false;
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

    /**
     * @return int
     *
     * @Serializer\Groups({"default", "test"})
     */
    public function getSumDrank(): int
    {
        $quantity = 0;
        foreach ($this->getEntries() as $entry) {
            $quantity += $entry->getQuantity();
        }

        return $quantity;
    }
}