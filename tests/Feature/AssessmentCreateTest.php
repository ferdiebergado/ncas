<?php

namespace Tests\Feature;

use App\Application;
use App\Assessment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssessmentCreateTest extends TestCase
{
    use RefreshDatabase;

    private function getData()
    {
        return [
            'application_id' => (factory(Application::class)->create())->application_id
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAssessmentIsCreated()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('assessments.store'), $this->getData());

        $response->assertStatus(200);

        $this->assertCount(1, Assessment::all());
    }
}
