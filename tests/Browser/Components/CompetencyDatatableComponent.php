<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class CompetencyDatatableComponent extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '#competency-datatable';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@search' => 'input[type=search]#search',
            '@order' => 'select#order',
            '@level' => 'select#level',
            '@category' => 'select#category',
            '@direction' => 'select#direction',
            '@btn-search' => 'button#btn-search',
            '@btn-sort' => 'button#btn-sort',
            '@btn-reset' => 'button#btn-reset',
            '@btn-export' => 'button#btn-export',
            '@pdf' => 'a#link-pdf',
            '@excel' => 'a#link-excel'
        ];
    }
}
