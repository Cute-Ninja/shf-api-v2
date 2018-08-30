<?php

namespace App\Repository\User;

use App\Repository\AbstractBaseRepository;

class UserBodyMeasurementRepository extends AbstractBaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return 'user_body_measurement';
    }
}