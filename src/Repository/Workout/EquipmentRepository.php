<?php

namespace App\Repository\Workout;

use App\Repository\AbstractBaseRepository;

class EquipmentRepository extends AbstractBaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'equipment';
    }
}