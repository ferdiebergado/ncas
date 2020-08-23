<?php

namespace Tests\Browser\Pages\Competency;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Page;

abstract class CompetencyBasePage extends Page
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@title' => 'input[type=text]#title',
            '@help-title' => 'p#help-title',
            '@level' => 'select#level_id',
            '@select-level' => 'div#select-level',
            '@help-level' => 'p#help-level',
            '@category' => 'select#category_id',
            '@select-category' => 'div#select-category',
            '@help-category' => 'p#help-category',
            '@submit' => 'button[type=submit]#btn-submit'
        ];
    }

    /**
     * Create a competency.
     *
     * @param Browser $browser
     * @param array $data
     * @return void
     */
    public function createCompetency(Browser $browser, $data = [])
    {
        if (isset($data['title'])) {
            $browser->type('title', $data['title']);
        }
        if (isset($data['level_id'])) {
            $browser->select('level_id', $data['level_id']);
        }
        if (isset($data['category_id'])) {
            $browser->select('category_id', $data['category_id']);
        }
        $browser->click('@submit');
    }
}
