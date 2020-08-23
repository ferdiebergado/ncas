<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\App;
use App\Repositories\CompetencyCachedRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CompetencyCachedRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCachedRepository()
    {
        $repo = App::make(CompetencyCachedRepository::class);

        $filter = ['level_id' => 1];

        $query = $repo->filter($filter);

        $result = $query->paginate(10);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
