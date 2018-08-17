<?php

namespace App\Repository;

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