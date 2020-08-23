<?php

namespace Tests\Browser\Competency;

use App\Competency;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Competency\CompetencyEditPage;
use Tests\Browser\Pages\Competency\CompetencyIndexPage;
use Tests\Browser\Pages\Competency\CompetencyCreatePage;

class CompetencyDeleteTest extends CompetencyBaseBrowserTestCase
{
    /**
     * Test delete a Competency.
     *
     * @return void
     */
    public function testDeleteCompetency()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CompetencyCreatePage)->createCompetency($this->_data());
            $browser->visit(new CompetencyIndexPage);
            $browser->clickLink('Delete');
            $browser->waitForDialog(1);
            $browser->acceptDialog();
            $browser->assertPathIs('/competencies');
            $browser->assertDontSee($this->_data()['title']);
        });
    }
}
