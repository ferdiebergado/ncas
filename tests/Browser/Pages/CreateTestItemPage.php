<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\TestItemOptionsComponent;

class CreateTestItemPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/testitems/create';
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

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@timeout' => 'input[type=number]#timeout',
            '@timeout-help' => 'p.help.is-danger#timeout-help',
            '@testitem-submit' => 'button#btn-submit',
        ];
    }

    /**
     * Create a test item.
     *
     * @param Browser $browser
     * @param array $data
     * @return void
     */
    public function createTestItem(Browser $browser, $data)
    {
        $browser->select('competency_uuid', $data['competency_uuid']);
        $browser->select('type', $data['type']);
        $browser->type('question', $data['question']);
        if ($data['type'] === 'M') {
            $options = $data['options'];
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($options, $data) {
                for ($i = 0; $i < count($options); $i++) {
                    $browser->addOption($options[$i]);
                }
                $browser->select('@answer', $data['answer']);
            });
        } else {
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($data) {
                $browser->select('@answer', $data['answer']);
            });
        }
        $browser->type('timeout', $data['timeout']);
        $browser->click('@testitem-submit');
    }

    public function changeType(Browser $browser, $type)
    {
        $browser->within(new TestItemOptionsComponent, function ($browser) use ($type) {
            $browser->select('@testitem-type', $type);
        });
    }

    public function setQuestion(Browser $browser, $question)
    {
        $browser->within(new TestItemOptionsComponent, function ($browser) use ($question) {
            $browser->type('@question', $question);
        });
    }

    public function addOption(Browser $browser, $option)
    {
        $browser->within(new TestItemOptionsComponent, function ($browser) use ($option) {
            $browser->type('@testitem-option', $option);
            $browser->click('@testitem-option-add');
        });
    }

    public function setAnswer(Browser $browser, $answer, $isIdentificationType = false)
    {
        $browser->within(new TestItemOptionsComponent, function ($browser) use ($isIdentificationType, $answer) {
            if (!$isIdentificationType) {
                $browser->select('@answer', $answer);
            } else {
                $browser->type('@answer-text', $answer);
            }
        });
    }

    public function submit(Browser $browser)
    {
        $browser->click('@testitem-submit');
    }
}
