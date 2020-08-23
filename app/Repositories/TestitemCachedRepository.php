<?php

namespace App\Repositories;

use App\TestItem;

class TestitemCachedRepository extends BaseRepository
{
    public function __construct(TestItem $testItem)
    {
        parent::__construct($testItem);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
