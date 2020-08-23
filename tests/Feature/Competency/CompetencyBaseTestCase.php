<?php

namespace Tests\Feature\Competency;

use App\User;
use App\Competency;
use App\Qualification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompetencyBaseTestCase extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $data;

    protected $user;

    protected $competency;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->actingAs($this->user);
    }

    protected function createCompetency($data)
    {
        $response = $this->post(route('competencies.store'), $data);

        $this->competency = Competency::first();

        return $response;
    }

    protected function getData()
    {
        factory(Qualification::class)->create();

        return [
            'level' => 1,
            'title' => 'Deliver Training Session',
            'qualification_id' => Qualification::first()->qualification_id
        ];
    }
}
