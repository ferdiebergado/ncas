<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CreateTestItemPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Components\TestItemOptionsComponent;

class CreateTestItemWithInvalidDataTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test errors are displayed for all fields after form submit
     *
     * @return void
     */
    public function testErrorsAreDisplayedWheFormIsSubmittedWithBlankData()
    {
        $this->browse(function (Browser $browser) {
            // All fields are blank
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->assertFocused('competency_id');
            $browser->clear('timeout');
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertVisible('@competency-help')
                    ->assertAttribute('@competency-select', 'class', $this->_data()['select_class'] . ' is-danger')
                    ->assertSeeIn('@competency-help', 'The competency field is required')
                    ->assertAttribute('@testitem-type-div', 'class', $this->_data()['select_class'] . ' is-danger')->assertVisible('@type-help')->assertSeeIn('@type-help', 'The type field is required.')
                    ->assertAttribute('@question', 'class', 'textarea is-danger')->assertVisible('@question-help')->assertSeeIn('@question-help', 'The question field is required.')
                    ->assertAttribute('@answer-select', 'class', $this->_data()['select_class'] . ' is-danger')->assertVisible('@answer-help')->assertSeeIn('@answer-help', 'The answer field is required.');
            });
            $browser->assertAttribute('@timeout', 'class', 'input  is-danger ')->assertVisible('@timeout-help')->assertSeeIn('@timeout-help', 'The timeout field is required.');
        });
    }

    public function testErrorMessageForAnswerTextInputFieldIsDisplayedWhenIdentificationTypeIsSelectedAndFormIsSubmittedWithBlankData()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->changeType('I');
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertAttribute('@answer-text', 'class', 'input is-danger')
                    ->assertVisible('@answer-help')
                    ->assertSeeIn('@answer-help', 'The answer field is required.');
            });
        });
    }

    public function testErrorMessageForAnswerTextInputFieldIsDisplayedWhenTrueOrFalseTypeIsSelectedAndFormIsSubmittedWithBlankData()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->changeType('T');
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertAttribute('@answer-select', 'class', $this->_data()['select_class'] . ' is-danger')
                    ->assertVisible('@answer-help')
                    ->assertSeeIn('@answer-help', 'The answer field is required.');
            });
        });
    }

    public function testProvidedInputIsPreservedOnTheFormWhenSubmittedWithMultipleChoiceTypeIsSelected()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);

            // Fill up form for multiple choice type
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->select('@competency', $this->_data()['competency']);
            });
            $browser->changeType($this->_data()['type'])
                ->setQuestion($this->_data()['question'])
                ->addOption($this->_data()['option'])
                ->setAnswer($this->_data()['option']);
            $browser->clear('timeout');
            $browser->submit();

            // Check if old input values are present on the respective fields
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertValue('@competency', $this->_data()['competency'])
                    ->assertValue('@testitem-type', $this->_data()['type'])
                    ->assertValue('@question', $this->_data()['question'])
                    ->assertValue('input[type=text]#opts0', $this->_data()['option'])
                    ->assertValue('@answer', $this->_data()['option']);
            });
        });
    }

    public function testInputForTypeAndAnswerIsPreservedOnTheFormWhenSubmittedWithTrueOrFalseTypeSelectedAndOtherDataIsBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);

            $browser->changeType($this->_data()['true'])
                ->setAnswer($this->_data()['true']);
            $browser->submit();

            // Check if old input values are present on the respective fields
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertValue('@testitem-type', $this->_data()['true'])
                    ->assertValue('@answer', $this->_data()['true']);
            });
        });
    }

    public function testInputForTypeAndAnswerIsPreservedOnTheFormWhenSubmittedWithIdentificationTypeSelectedAndOtherDataIsBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);

            $i = 'I';

            $browser->changeType($i);
            $browser->setAnswer($this->_data()['answer'], true);
            $browser->submit();

            // Check if old input values are present on the respective fields
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($i) {
                $browser->assertValue('@testitem-type', $i)
                    ->assertValue('@answer-text', $this->_data()['answer']);
            });
        });
    }

    public function testTimeoutInputIsPreservedOnTheFormWhenSubmittedWithOtherDataBlank()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);

            $browser->type('@timeout', $this->_data()['timeout']);
            $browser->submit();
            $browser->assertValue('@timeout', $this->_data()['timeout']);
        });
    }

    public function testCompetencyIdErrorMessageIsHiddenWhenCompetencyIdIsFilledUp()
    {
        $this->browse(function (Browser $browser) {
            // All fields are blank
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertVisible('@competency-help');
                $browser->select('@competency', '1');
                $browser->assertMissing('@competency-help');
                $browser->select('@competency', '');
                $browser->assertVisible('@competency-help');
            });
        });
    }

    public function testTypeErrorMessageIsHiddenWhenTypeIsFilledUp()
    {
        $this->browse(function (Browser $browser) {
            // All fields are blank
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertVisible('@type-help');
                $browser->select('@testitem-type', 'M');
                $browser->assertMissing('@type-help');
                $browser->select('@testitem-type', '');
                $browser->assertVisible('@type-help');
            });
        });
    }

    public function testQuestionErrorMessageIsHiddenWhenQuestionIsFilledUp()
    {
        $this->browse(function (Browser $browser) {
            $el = '@question';
            $help = '@question-help';

            // All fields are blank
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($el, $help) {
                $browser->assertVisible($help);
                $browser->type($el, 'What is that?');
                $browser->assertMissing($help);
            });
            // $browser->clear('question')->assertVisible($help);
        });
    }

    public function testOptionErrorMessageIsHiddenWhenAnOptionIsAdded()
    {
        $this->browse(function (Browser $browser) {
            $help = '@testitem-option-help';

            // All fields are blank
            $browser->loginAs($this->_data()['user'])->visit(new CreateTestItemPage);
            $browser->changeType('M');
            $browser->submit();
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($help) {
                $browser->assertVisible($help);
            });
            $browser->addOption('Dumb Lovers')->assertMissing($help);
        });
    }

    private function _data()
    {
        return [
            'user' => factory(User::class)->create(),
            'select_class' => 'select is-fullwidth',
            'true' => 'T',
            'competency' => 1,
            'type' => 'M',
            'question' => "What?",
            'option' => "new option",
            'answer' => 'gothic',
            'timeout' => 30
        ];
    }
}
