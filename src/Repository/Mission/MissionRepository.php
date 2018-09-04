<?php

namespace App\Repository\Mission;

use App\Repository\AbstractBaseRepository;

class MissionRepository extends AbstractBaseRepository
{
    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'mission';
    }
}