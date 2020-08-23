<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;

class ApplicationObserverTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $application = factory(Application::class)->make();

        $this->assertEquals(1, $application->coc_count);
    }
}
