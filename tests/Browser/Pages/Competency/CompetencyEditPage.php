<?php

namespace Tests\Browser\Pages\Competency;

use Laravel\Dusk\Browser;

class CompetencyEditPage extends CompetencyBasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/competencies/1/edit';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }
}
