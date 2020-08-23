<?php

namespace Tests\Feature\Competency;

use App\Competency;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CompetencyCreateTest extends CompetencyBaseTestCase
{
    /**
     * Test a logged in user can view the create competency form.
     *
     * @return void
     */
    public function testALoggedInUserCanViewCompetencyCreateForm()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(route('competencies.create'));

        $response->assertSuccessful();

        $response->assertViewIs('competency.create');
    }

    /**
     * Test a guest cannot can view the create competency form.
     *
     * @return void
     */
    public function testAGuestCannotViewCompetencyCreateForm()
    {
        Auth::logout();

        $response = $this->get(route('competencies.create'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a logged in user can create a competency.
     *
     * @return void
     */
    public function testALoggedInUserCanCreateACompetency()
    {
        $this->withoutExceptionHandling();
        $response = $this->createCompetency($this->getData());

        $this->assertCount(1, Competency::all());

        $this->competency = Competency::first();
        $response->assertSessionHas('success');

        $response->assertRedirect(route('competencies.show', $this->competency));
    }

    /**
     * Test a guest cannot create a competency.
     *
     * @return void
     */
    public function testAGuestCannotCreateACompetency()
    {
        Auth::logout();
        $response = $this->createCompetency($this->getData());

        $response->assertRedirect(route('login'));
    }

    /**
     * Test competency title is should not exceed max characters.
     *
     * @return void
     */
    public function testTitleShouldNotExceedMaxCharacters()
    {
        $title = Str::random(150);
        $data = array_merge($this->getData(), compact('title'));
        $response = $this->createCompetency($data);

        $this->assertCount(0, Competency::all());

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test competency level is required.
     *
     * @return void
     */
    public function testLevelIsRequired()
    {
        $data = Arr::except($this->getData(), 'level');
        $response = $this->createCompetency($data);

        $this->assertCount(0, Competency::all());

        $response->assertSessionHasErrors('level');
    }

    public function testLevelMustBeWithinRange()
    {
        $level = 10;
        $data = array_merge($this->getData(), compact('level'));
        $response = $this->createCompetency($data);

        $response->assertSessionHasErrors('level');

        $this->assertCount(0, Competency::all());
    }

    public function testQualificationIdShouldExistInTheDatabase()
    {
        $qualification_id = 10;
        $data = array_merge($this->getData(), compact('qualification_id'));
        $response = $this->createCompetency($data);

        $response->assertSessionHasErrors('qualification_id');

        $this->assertCount(0, Competency::all());
    }
}
