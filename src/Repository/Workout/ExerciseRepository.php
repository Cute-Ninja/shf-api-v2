<?php

namespace App\Repository\Workout;

use App\Repository\AbstractBaseRepository;

class ExerciseRepository extends AbstractBaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'exercise';
    }
}