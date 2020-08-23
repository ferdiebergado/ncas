<?php

namespace Tests\Feature\TestItem;

use App\User;
use App\Competency;
use App\TestItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestItemAbstractBaseTestCase extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected $testitem;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->actingAs($this->user);

        $this->createCompetencies();
    }

    protected function _data()
    {
        $options = [
            'CMS',
            'JS',
            'MVC',
            'HTML'
        ];

        return [
            'competency_uuid' => Competency::first()->uuid,
            'type' => 'M',
            'question' => 'What?',
            'options' => $options,
            'answer' => $options[1],
            'timeout' => 30
        ];
    }

    protected function _competencyData()
    {
        return [
            'title' => $this->faker->words(2, true),
            'level_id' => array_rand(Competency::LEVELS),
            'category_id' => array_rand(Competency::CATEGORIES)
        ];
    }

    protected function createTestItem()
    {
        $this->post(route('testitems.store'), $this->_data());

        $this->testitem = TestItem::first();
    }

    protected function createCompetencies()
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('competencies.store'), $this->_competencyData());
        }
    }
}
