<?php

namespace Tests\Feature\Competency;

use App\Competency;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;

class CompetencyUpdateTest extends CompetencyBaseTestCase
{
    /**
     * Test a logged in user can view the edit competency form.
     *
     * @return void
     */
    public function testALoggedInUserCanViewCompetencyEditForm()
    {
        $this->createCompetency();
        $response = $this->get(route('competencies.edit', $this->competency));

        $response->assertSuccessful();
        $response->assertViewIs('competency.edit');
        $response->assertViewHas('competency');
    }

    /**
     * Test a guest cannot can view the edit competency form.
     *
     * @return void
     */
    public function testAGuestCannotViewCompetencyEditForm()
    {
        $this->createCompetency();
        Auth::logout();

        $response = $this->get(route('competencies.edit', $this->competency));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test a logged in user can update a competency.
     *
     * @return void
     */
    public function testALoggedInUserCanUpdateACompetency()
    {
        $this->createCompetency();
        $newData = [
            'title' => $this->faker->sentence(2, false),
            'level_id' => $this->faker->numberBetween(1, 3),
            'category_id' => $this->faker->numberBetween(1, 5)
        ];

        $response = $this->put(route('competencies.update', $this->competency), $newData);

        $this->assertDatabaseHas((new Competency)->getTable(), $newData);

        $response->assertRedirect(route('competencies.show', $this->competency));

        $response->assertSessionHas('success');

        $redirect = $this->followRedirects($response);

        $redirect->assertViewIs('competency.show');
        $redirect->assertViewHas('competency', $this->competency->fresh());
    }

    /**
     * Test a guest cannot update a competency.
     *
     * @return void
     */
    public function testAGuestCannotUpdateACompetency()
    {
        $this->createCompetency();
        Auth::logout();
        $response = $this->put(route('competencies.update', $this->competency), $this->data);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test competency title is required.
     *
     * @return void
     */
    public function testTitleIsRequired()
    {
        $this->createCompetency();
        $data = Arr::except($this->data, 'title');
        $response = $this->put(route('competencies.update', $this->competency), $data);

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test competency title is should not exceed max characters.
     *
     * @return void
     */
    public function testTitleShouldNotExceedMaxCharacters()
    {
        $this->createCompetency();
        $title = ['title' => $this->faker->paragraph];

        $data = array_merge($this->data, $title);
        $response = $this->put(route('competencies.update', $this->competency), $data);

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test competency level is required.
     *
     * @return void
     */
    public function testLevelIsRequired()
    {
        $this->createCompetency();
        $data = Arr::except($this->data, 'level_id');
        $response = $this->put(route('competencies.update', $this->competency), $data);

        $response->assertSessionHasErrors('level_id');
    }

    /**
     * Test competency level must be within a specified list.
     *
     * @return void
     */
    public function testLevelShouldBeWithinList()
    {
        $this->createCompetency();
        $level = ['level_id' => 5];

        $data = array_merge($this->data, $level);
        $response = $this->put(route('competencies.update', $this->competency), $data);

        $response->assertSessionHasErrors('level_id');
    }

    /**
     * Test competency category is required.
     *
     * @return void
     */
    public function testCategoryIsRequired()
    {
        $this->createCompetency();
        $data = Arr::except($this->data, 'category_id');
        $response = $this->put(route('competencies.update', $this->competency), $data);

        $response->assertSessionHasErrors('category_id');
    }
}
