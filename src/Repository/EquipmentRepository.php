<?php

namespace App\Repository;

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