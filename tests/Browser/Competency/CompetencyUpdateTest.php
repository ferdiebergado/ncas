<?php

namespace Tests\Browser\Competency;

use App\Competency;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Competency\CompetencyEditPage;
use Tests\Browser\Pages\Competency\CompetencyCreatePage;

class CompetencyUpdateTest extends CompetencyBaseBrowserTestCase
{
    /**
     * Test Competency edit form is displayed.
     *
     * @return void
     */
    public function testCompetencyEditFormIsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyEditPage);
            $browser->assertSeeIn('p.card-header-title', 'EDIT COMPETENCY');
            $browser->assertVisible('@title');
            $browser->assertAttribute('@title', 'type', 'text');
            $browser->assertAttribute('@title', 'required', 'true');
            $browser->assertAttribute('@title', 'min', '3');
            $browser->assertAttribute('@title', 'max', '200');
            $browser->assertAttribute('@title', 'name', 'title');
            $browser->assertAttribute('@title', 'placeholder', 'Title');
            $browser->assertAttribute('@title', 'autofocus', 'true');
            $browser->assertValue('@title', $this->_data()['title']);
            $browser->assertVisible('@level');
            $browser->assertAttribute('@level', 'name', 'level_id');
            $browser->assertSelectHasOptions('level_id', array_keys(Competency::LEVELS));
            $browser->assertAttribute('@level', 'required', 'true');
            $browser->assertSelected('level_id', $this->_data()['level_id']);
            $browser->assertVisible('@category');
            $browser->assertAttribute('@category', 'name', 'category_id');
            $browser->assertSelectHasOptions('category_id', array_keys(Competency::CATEGORIES));
            $browser->assertAttribute('@category', 'required', 'true');
            $browser->assertSelected('category_id', $this->_data()['category_id']);
            $browser->assertVisible('@submit');
        });
    }

    /**
     * Test update a competency.
     *
     * @return void
     */
    public function testUpdateACompetency()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $competency = Competency::first();
            $data = [
                'title' => 'Arc Welding',
                'level_id' => 2,
                'category_id' => 5
            ];

            $browser->visit(new CompetencyEditPage)->createCompetency($data);
            $browser->assertSee($competency->id);
            $browser->assertSee($data['title']);
            $browser->assertSee(Competency::LEVELS[$data['level_id']]);
            $browser->assertSee(Competency::CATEGORIES[$data['category_id']]);
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
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyEditPage);
            $browser->clear('title');
            $browser->click('@submit');
            $browser->assertAttribute('@title', 'class', 'input is-danger')
                ->assertVisible('@help-title')
                ->assertValue('@level', $this->_data()['level_id'])
                ->assertValue('@category', $this->_data()['category_id']);
        });
    }

    /**
     * Test should show error indicators when form is submitted with blank level.
     *
     * @return void
     */
    public function testShouldShowErrorsWithOldInputWhenSubmittedWithBlankLevel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyEditPage);
            $browser->select('@level', '');
            $browser->click('@submit');
            $browser->assertAttribute('@select-level', 'class', 'select is-fullwidth is-danger')
                ->assertVisible('@help-level')
                ->assertValue('@title', $this->_data()['title'])
                ->assertValue('@category', $this->_data()['category_id']);
        });
    }

    /**
     * Test should show error indicators when form is submitted with blank category.
     *
     * @return void
     */
    public function testShouldShowErrorsWithOldInputWhenSubmittedWithBlankCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyEditPage);
            $browser->select('@category', '');
            $browser->click('@submit');
            $browser->assertAttribute('@select-category', 'class', 'select is-fullwidth is-danger')
                ->assertVisible('@help-category')
                ->assertValue('@title', $this->_data()['title'])
                ->assertValue('@level', $this->_data()['level_id']);
        });
    }
}
