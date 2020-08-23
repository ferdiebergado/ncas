<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssessorRegistrationTest extends TestCase
{
    /**
     * Test an assessor registration.
     *
     * @return void
     */
    public function testCanDisplayTheAssessorRegistrationForm()
    {
        $response = $this->get('/assessors/register');

        $response->assertStatus(200);

        $response->assertViewIs('auth.register');
    }
}
