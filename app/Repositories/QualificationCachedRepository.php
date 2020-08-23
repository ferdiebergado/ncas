<?php

namespace App\Repositories;

use App\Qualification;

class QualificationCachedRepository extends BaseRepository
{
    public function __construct(Qualification $qualification)
    {
        parent::__construct($qualification);
    }
}
