<?php

namespace Tests\Browser;

use App\Competency;
use App\User;
use App\TestItem;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ShowTestItemPage;
use Tests\Browser\Pages\TestItemEditPage;
use Tests\Browser\Pages\TestItemIndexPage;
use Tests\Browser\Pages\CreateTestItemPage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Components\TestItemOptionsComponent;

class TestItemManagementTest extends DuskTestCase
{
    use DatabaseMigrations, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        factory(Competency::class, 5)->create();
    }

    public function testFormElementsAreProperlySetUp()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CreateTestItemPage);

            // Card Title
            $browser->assertSeeIn('p.card-header-title', 'NEW TEST ITEM');

            $browser->within(new TestItemOptionsComponent, function ($browser) {
                // Competency
                $browser->assertSelectHasOptions('competency_uuid', Competency::all()->pluck('uuid')->toArray());
                $browser->assertAttribute('@competency', 'required', 'true');
                $browser->assertFocused('competency_uuid');

                // Type
                $browser->assertSelectHasOptions('type', [
                    'M',
                    'T',
                    'I',
                ]);
                $browser->assertAttribute('@testitem-type', 'required', 'true');

                // Question
                $browser->assertAttribute('@question', 'rows', 4);
                $browser->assertAttribute('@question', 'maxlength', 250);
                $browser->assertAttribute('@question', 'required', 'true');

                // Options
                $browser->assertMissing('@testitem-option');
                $browser->assertMissing('@testitem-option-add');

                // Answer
                $browser->assertAttribute('@answer', 'required', 'true');
                $browser->assertMissing('@answer-text');
            });

            // timeout
            $browser->assertAttribute('@timeout', 'required', 'true');
            $browser->assertAttribute('@timeout', 'min', '5');
            $browser->assertAttribute('@timeout', 'max', '600');
            $browser->assertValue('@timeout', 15);

            // submit button
            $browser->assertButtonEnabled('Save');
        });
    }

    /**
     * New test item form test.
     *
     * @return void
     */
    public function testCreateTestItemForm()
    {
        $this->browse(function (Browser $browser) {
            $tfoptions = ['T', 'F'];

            $browser->loginAs($this->user)->visit(new CreateTestItemPage);

            // Select a competency
            $browser->select('competency_uuid', $this->_dataMulti()['competency_uuid']);

            // Select a type
            $browser->changeType($this->_dataMulti()['type']);
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertVisible('@testitem-option')->assertVisible('@testitem-option-add');
            });
            $browser->changeType('T')->assertMissing('@testitem-option')->assertMissing('@testitem-option-add')->assertSelectHasOptions('answer', $tfoptions);
            $browser->changeType('I');
            $browser->within(new TestItemOptionsComponent, function ($browser) {
                $browser->assertVisible('@answer-text')->assertMissing('@answer');
            });
            $browser->changeType($this->_dataMulti()['type'])->assertSelectMissingOptions('answer', $tfoptions);

            // Type a question
            $browser->type('question', $this->_dataMulti()['question']);

            // Add options using the add button
            $addButton = 'Add option';
            $browser->within(new TestItemOptionsComponent, function () {
            })->assertButtonDisabled($addButton);
            $options = $this->_dataMulti()['options'];
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($options) {
                $browser->type('option', $options[0]);
            })->assertButtonEnabled($addButton);
            $browser->clear('option');
            for ($i = 0; $i < count($options); $i++) {
                $browser->addOption($options[$i]);
            }
            for ($i = 0; $i < count($options); $i++) {
                $browser->assertVisible('input[type=text]#opts' . $i);
                $browser->assertValue('input[type=text]#opts' . $i, $options[$i]);
                $browser->within(
                    new TestItemOptionsComponent,
                    function ($browser) use ($i) {
                        $browser->assertVisible('@testitem-option-del' . $i);
                    }
                );
            }
            $browser->assertSelectHasOptions('answer', $options);

            // Add an option by pressing enter key
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($options) {
                $browser->keys('@testitem-option', 'b', '{enter}');
            });
            $browser->assertSelectHasOption('answer', 'b');
            $lastoption = count($options);
            $browser->assertVisible('input[type=text]#opts' . $lastoption);
            $browser->assertValue('input[type=text]#opts' . $lastoption, 'b');

            // Verify if options are properly displayed and answer has appropriate options when type is changed
            $browser->changeType('T');
            for ($i = 0; $i < (count($options) + 1); $i++) {
                $browser->assertMissing('input[type=text]#opts' . $i);
                $browser->assertMissing('@testitem-option-del' . $i);
            }
            $browser->assertSelectHasOptions('answer', $tfoptions);
            $browser->assertSelectMissingOptions('answer', array_merge($options, ['b']));
            $browser->changeType($this->_dataMulti()['type']);
            for ($i = 0; $i < (count($options) + 1); $i++) {
                $browser->assertVisible('input[type=text]#opts' . $i);
                $browser->within(
                    new TestItemOptionsComponent,
                    function ($browser) use ($i) {
                        $browser->assertVisible('@testitem-option-del' . $i);
                    }
                );
            }
            $browser->assertSelectHasOptions('answer', array_merge($options, ['b']));
            $browser->assertSelectMissingOptions('answer', $tfoptions);

            // Delete an option
            $optIndex = 4;
            $browser->within(new TestItemOptionsComponent, function ($browser) use ($optIndex) {
                $browser->deleteOption($optIndex);
            });
            $browser->assertMissing('input[type=text]#opts' . $optIndex);
            $browser->assertSelectMissingOption('answer', 'b');
            $browser->assertSelectHasOptions('answer', $options);

            // Select an answer
            $browser->select('answer', $options[$this->_dataMulti()['answer']]);

            // Submit the form
            $browser->submit();

            // Should redirect to testitems.show route
            $testitem = TestItem::first();
            $browser->assertPathIs('/testitems/' . $testitem->id);
        });
    }

    public function testTestItemList()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CreateTestItemPage);
            $browser->createTestItem($this->_data());
            $browser->visit(new TestItemIndexPage);
            $browser->assertSee('TEST ITEMS');
            $browser->assertSeeLink('NEW');
            $browser->assertSee(Competency::first()->title);
            $browser->assertSee(TestItem::TYPES[$this->_data()['type']]);
            $browser->assertSee($this->_data()['timeout']);
            $browser->assertSeeLink('View');
            $browser->assertSeeLink('Edit');
            $browser->assertSeeLink('Delete');
        });
    }

    public function testShowTestItemPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)->visit(new CreateTestItemPage);
            $browser->createTestItem($this->_data());
            $browser->visit(new ShowTestItemPage);
            $browser->assertSee('VIEW TEST ITEM');
            foreach (array_values($this->_data()) as $value) {
                $browser->assertSee($value);
            }
            $browser->assertSeeLink('Edit');
            $browser->assertSeeLink('Close');

            $browser->clickLink('Edit');
            $browser->assertPathIs('/testitems/1/edit');
            $browser->visit(new ShowTestItemPage);
            $browser->clickLink('Close');
            $browser->assertPathIs('/testitems');
        });
    }

    public function testTestItemEditPage()
    {
        $this->browse(function (Browser $browser) {

            $browser->loginAs($this->user)->visit(new CreateTestItemPage);
            $browser->createTestItem($this->_data());
            $browser->visit(new TestItemEditPage);
            $browser->assertSee('EDIT TEST ITEM');
            foreach (array_values($this->_data()) as $value) {
                $browser->assertSee($value);
            }
            $browser->assertSeeLink('Save');
            $browser->assertSeeLink('Delete');
            $browser->assertSeeLink('Close');

            $browser->clickLink('Save');
            $browser->assertPathIs('/testitems/1');
            $browser->visit(new TestItemEditPage);
            $browser->clickLink('Close');
            $browser->assertPathIs('/testitems');
        });
    }

    private function _data()
    {
        return [
            'competency_uuid' => Competency::first()->uuid,
            'type' => 'T',
            'question' => 'Who are you?',
            'answer' => 'T',
            'timeout' => 20
        ];
    }

    private function _dataMulti()
    {
        return [
            'competency_uuid' => Competency::first()->uuid,
            'type' => 'M',
            'question' => 'Who the hell are you?',
            'options' => [
                'I am me.',
                'I dont know.',
                'Im you!',
                'Im lost...'
            ],
            'answer' => 0,
            'timeout' => 30
        ];
    }
}
