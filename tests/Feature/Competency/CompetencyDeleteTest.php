<?php

namespace Tests\Feature\Competency;

use App\Competency;
use Illuminate\Support\Facades\Auth;

class CompetencyDeleteTest extends CompetencyBaseTestCase
{
    /**
     * Test a logged in user can delete a competency.
     *
     * @return void
     */
    public function testALoggedInUserCanDeleteACompetency()
    {
        $this->createCompetency();

        $response = $this->delete(route('competencies.destroy', $this->competency));

        $this->assertDatabaseMissing((new Competency)->getTable(), $this->data);

        $response->assertRedirect(route('competencies.index'));

        $response->assertSessionHas('success');

        $redirect = $this->followRedirects($response);

        $redirect->assertViewIs('competency.index');
    }

    /**
     * Test a guest cannot delete a competency.
     *
     * @return void
     */
    public function testAGuestCannotDeleteACompetency()
    {
        $this->createCompetency();
        Auth::logout();
        $response = $this->delete(route('competencies.destroy', $this->competency));

        $response->assertRedirect(route('login'));
    }
}
