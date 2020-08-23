<?php

namespace Tests\Feature;

use App\User;
use App\Competency;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutoCacheTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $cache;

    private $competency;

    private $data;

    private $key;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->cache = Cache::tags((new Competency())->getTable());

        $this->data = [
            'title' => $this->faker->words(2, true),
            'level_id' => array_rand(Competency::LEVELS),
            'category_id' => array_rand(Competency::CATEGORIES),
            'coc_number' => $this->faker->numberBetween(1, 3),
            'coc_title' => $this->faker->words(2, true),
            'units_covered' => [
                $this->faker->sentence,
                $this->faker->sentence,
                $this->faker->sentence
            ]
        ];

        $this->setUser();

        $this->createCompetency();
    }

    private function setUser()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    private function createCompetency()
    {
        $this->post(route('competencies.store'), $this->data);

        $this->competency = Competency::first();
        $this->key = $this->competency->slug;
    }

    /**
     * Test a model is cached on create.
     *
     * @return void
     */
    public function testModelIsCachedOnEdit()
    {
        $this->assertFalse($this->cache->has($this->key));

        $this->get(route('competencies.edit', $this->competency));

        $this->assertTrue($this->cache->has($this->key));
        $this->assertEquals($this->cache->get($this->key), $this->competency);
    }

    /**
     * Test a model is cached on create.
     *
     * @return void
     */
    public function ModelIsCachedOnShow()
    {
        $this->get(route('competencies.show', $this->competency));

        $this->assertTrue($this->cache->has($this->key));
        $this->assertEquals($this->cache->get($this->key), $this->competency);
    }

    /**
     * Test cache is flushed on model create.
     *
     * @return void
     */
    public function CacheIsFlushedOnModelCreate()
    {
        $this->assertFalse($this->cache->has($this->key));

        $this->get(route('competencies.show', $this->competency));

        $this->assertTrue($this->cache->has($this->key));

        $this->createCompetency();

        $this->assertFalse($this->cache->has($this->key));
    }

    /**
     * Test cache is flushed on model update.
     *
     * @return void
     */
    public function testCacheIsFlushedOnModelUpdate()
    {
        $this->assertFalse($this->cache->has($this->key));

        $this->put(route('competencies.update', $this->competency), $this->data);

        $this->assertFalse($this->cache->has($this->key));
    }

    /**
     * Test cache is flushed on model delete.
     *
     * @return void
     */
    public function testCacheIsFlushedOnModelDelete()
    {
        $this->assertFalse($this->cache->has($this->key));

        $this->delete(route('competencies.update', $this->competency));

        $this->assertFalse($this->cache->has($this->key));
    }
}
