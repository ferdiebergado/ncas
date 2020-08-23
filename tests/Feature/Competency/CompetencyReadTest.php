<?php

namespace Tests\Feature\Competency;

use App\Competency;
use Illuminate\Support\Facades\Auth;

class CompetencyReadTest extends CompetencyBaseTestCase
{
    /**
     * Test a logged in user can view the competency list.
     *
     * @return void
     */
    public function testALoggedInUserCanViewTheCompetencyList()
    {
        $this->createCompetency();
        $response = $this->get(route('competencies.index'));

        $response->assertStatus(200);
        $response->assertViewIs('competency.index');
        $response->assertViewHas('competencies');
    }

    /**
     * Test a guest cannot view the competency list.
     *
     * @return void
     */
    public function testAGuestCannotViewTheCompetencyList()
    {
        $this->createCompetency();
        Auth::logout();

        $response = $this->get(route('competencies.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a logged in user can view the competency list.
     *
     * @return void
     */
    public function testALoggedInUserCanViewACompetency()
    {
        $this->createCompetency();
        $response = $this->get(route('competencies.show', $this->competency));

        $response->assertStatus(200);
        $response->assertViewIs('competency.show');
        $response->assertViewHas('competency');

        $id = $this->competency->id;
        $this->assertTrue($this->cache->has($id));
        $this->assertEquals($this->competency, $this->cache->get($id));
    }

    /**
     * Test a guest cannot view the competency list.
     *
     * @return void
     */
    public function testAGuestCannotViewACompetency()
    {
        $this->createCompetency();
        Auth::logout();

        $response = $this->get(route('competencies.show', $this->competency));

        $response->assertRedirect(route('login'));
    }
}
