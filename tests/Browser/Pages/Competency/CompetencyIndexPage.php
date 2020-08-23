<?php

namespace Tests\Browser\Pages\Competency;

use Laravel\Dusk\Browser;

class CompetencyIndexPage extends CompetencyBasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/competencies';
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
