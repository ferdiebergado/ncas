<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class TestItemOptionsComponent extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '#testitem-form';
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
            '@competency' => 'select#competency_id',
            '@competency-help' => 'p.help.is-danger#competency-help',
            '@competency-select' => 'div#select-competency',
            '@testitem-type' => 'select#type',
            '@testitem-type-div' => 'div#select-type',
            '@type-help' => 'p.help.is-danger#type-help',
            '@question' => 'textarea#question',
            '@question-help' => 'p.help.is-danger#question-help',
            '@testitem-option' => 'input[type=text]#option',
            '@testitem-option-add' => 'button#btn-add',
            '@testitem-option-del' => 'button#btn-del',
            '@testitem-option-help' => 'p.help.is-danger#option-help',
            '@testitem-opts' => 'input[type=text]#opts',
            '@answer' => 'select#answer',
            '@answer-select' => 'div#select-answer',
            '@answer-help' => 'p.help.is-danger#answer-help',
            '@answer-text' => 'input[type=text]#answer',
        ];
    }

    public function deleteOption(Browser $browser, $index)
    {
        $browser->click('button#btn-del' . $index);
    }
}
