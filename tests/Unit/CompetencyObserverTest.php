<?php

namespace Tests\Unit;

use App\Competency;
use App\Qualification;
use PHPUnit\Framework\TestCase;

class CompetencyObserverTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $data = [
            'title' => 'Object Oriented Programming',
            'level' => 1,
            'qualification_id' => Qualification::first()->qualification_id
        ];

        $competency = Competency::create($data);

        $this->assertEquals($competency->competency_id, '');
    }
}
