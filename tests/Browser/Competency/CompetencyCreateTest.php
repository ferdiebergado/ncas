<?php

namespace Tests\Browser\Competency;

use App\Competency;
use Laravel\Dusk\Browser;
use Illuminate\Support\Arr;
use Tests\Browser\Pages\Competency\CompetencyCreatePage;

class CompetencyCreateTest extends CompetencyBaseBrowserTestCase
{
    /**
     * Test Competency create form is displayed.
     *
     * @return void
     */
    public function testCompetencyCreateFormIsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage);
            $browser->assertSeeIn('p.card-header-title', 'CREATE NEW COMPETENCY');
            $browser->assertVisible('@title');
            $browser->assertAttribute('@title', 'type', 'text');
            $browser->assertAttribute('@title', 'required', 'true');
            $browser->assertAttribute('@title', 'min', '3');
            $browser->assertAttribute('@title', 'max', '200');
            $browser->assertAttribute('@title', 'name', 'title');
            $browser->assertAttribute('@title', 'placeholder', 'Title');
            $browser->assertAttribute('@title', 'autofocus', 'true');
            $browser->assertVisible('@level');
            $browser->assertAttribute('@level', 'name', 'level_id');
            $browser->assertSelectHasOptions('level_id', array_keys(Competency::LEVELS));
            $browser->assertAttribute('@level', 'required', 'true');
            $browser->assertVisible('@category');
            $browser->assertAttribute('@category', 'name', 'category_id');
            $browser->assertSelectHasOptions('category_id', array_keys(Competency::CATEGORIES));
            $browser->assertAttribute('@category', 'required', 'true');
            $browser->assertVisible('@submit');
        });
    }

    /**
     * Test create a competency.
     *
     * @return void
     */
    public function testCreateCompetency()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data())
                ->assertPathIs('/competencies/1');
        });
    }

    /**
     * Test should show error indicators when form is submitted with blank title.
     *
     * @return void
     */
    public function testShouldShowErrorsWithOldInputWhenSubmittedWithBlankTitle()
    {
        $this->browse(function (Browser $browser) {
            $data = Arr::except($this->_data(), 'title');
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($data)
                ->assertAttribute('@title', 'class', 'input is-danger')
                ->assertVisible('@help-title')
                ->assertValue('@level', $data['level_id'])
                ->assertValue('@category', $data['category_id']);
        });
    }

    /**
     * Test should show error indicators when form is submitted with blank level.
     *
     * @return void
     */
    public function testShouldShowErrorsWhenSubmittedWithBlankLevel()
    {
        $this->browse(function (Browser $browser) {
            $data = Arr::except($this->_data(), 'level_id');
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($data)
                ->assertAttribute('@select-level', 'class', 'select is-fullwidth is-danger')
                ->assertVisible('@help-level')
                ->assertValue('@title', $data['title'])
                ->assertValue('@category', $data['category_id']);
        });
    }

    /**
     * Test should show error indicators when form is submitted with blank category.
     *
     * @return void
     */
    public function testShouldShowErrorsWhenSubmittedWithBlankCategory()
    {
        $this->browse(function (Browser $browser) {
            $data = Arr::except($this->_data(), 'category_id');
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($data)
                ->assertAttribute('@select-category', 'class', 'select is-fullwidth is-danger')
                ->assertVisible('@help-category')
                ->assertValue('@title', $data['title'])
                ->assertValue('@level', $data['level_id']);
        });
    }
}
