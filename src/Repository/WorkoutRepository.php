<?php

namespace App\Repository;

class WorkoutRepository extends AbstractBaseRepository
{
    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'workout';
    }
}