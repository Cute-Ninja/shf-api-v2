<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;

class CommunityWorkout extends AbstractWorkout
{
    public const WORKOUT_SOURCE_COMMUNITY = 'community';

    /**
     * @var User
     *
     * @Serializer\Groups({"creator"})
     */
    protected $creator;

    /**
     * @return string
     */
    public function getSource(): string
    {
        return self::WORKOUT_SOURCE_COMMUNITY;
    }

    /**
     * @return User
     */
    public function getCreator(): User
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator(User $creator): void
    {
        $this->creator = $creator;
    }
}