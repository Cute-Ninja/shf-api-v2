<?php

namespace App\Repository;

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