<?php

namespace App\Repositories;

use App\Competency;

class CompetencyCachedRepository extends BaseRepository
{
    public function __construct(Competency $competency)
    {
        parent::__construct($competency);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
