<?php

namespace Tests\Browser\Competency;

use App\Competency;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Competency\CompetencyShowPage;
use Tests\Browser\Pages\Competency\CompetencyIndexPage;
use Tests\Browser\Pages\Competency\CompetencyCreatePage;

class CompetencyReadTest extends CompetencyBaseBrowserTestCase
{
    /**
     * Test Competency create form is displayed.
     *
     * @return void
     */
    public function testShowCompetencyPageIsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyShowPage);
            $browser->assertSeeIn('p.card-header-title', 'VIEW COMPETENCY');
            $browser->assertSee('ID');
            $browser->assertSee('Title');
            $browser->assertSee('Level');
            $browser->assertSee('Category');
            foreach ($this->_data() as $key => $value) {
                $browser->assertSee($value);
            }
            $browser->assertSeeLink('Edit');
            $browser->assertSeeLink('Close');
            $browser->clickLink('Edit');
            $browser->assertPathIs('/competencies/1/edit');
            $browser->back();
            $browser->clickLink('Close');
            $browser->assertPathIs('/competencies');
        });
    }

    /**
     * Test Competency create form is displayed.
     *
     * @return void
     */
    public function testCompetencyIndexPageIsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyIndexPage);
            $browser->assertSeeIn('p.card-header-title', 'COMPETENCIES');
            $browser->assertSee('ID');
            $browser->assertSee('Title');
            $browser->assertSee('Level');
            $browser->assertSee('Category');
            $browser->assertSee($this->_data()['title']);
            $browser->assertSee(Competency::LEVELS[$this->_data()['level_id']]);
            $browser->assertSee(Competency::CATEGORIES[$this->_data()['category_id']]);
            $browser->assertSeeLink('View');
            $browser->assertSeeLink('Edit');
            $browser->assertSeeLink('Delete');
            $browser->clickLink('View');
            $browser->assertPathIs('/competencies/1');
            $browser->back();
            $browser->clickLink('Edit');
            $browser->assertPathIs('/competencies/1/edit');
        });
    }
}
