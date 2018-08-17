<?php

namespace App\Repository;

class UserEquipmentRepository extends AbstractBaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'user_equipment';
    }
}