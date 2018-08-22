<?php

namespace App\Repository;

class ReferenceWorkoutRepository extends WorkoutRepository
{
    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'reference_workout';
    }
}