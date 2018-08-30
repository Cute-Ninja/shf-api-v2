<?php

namespace App\Repository\User;

use App\Repository\AbstractBaseRepository;

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