<?php

namespace Tests\Feature\TestItem;

use App\Competency;
use App\TestItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TestItemCreateTest extends TestItemAbstractBaseTestCase
{
    public function testALoggedInUserCanViewTheCreateTestItemForm()
    {
        $response = $this->get(route('testitems.create'));

        $response->assertViewIs('test-items.create');
    }

    public function testAGuestCannotViewTheCreateTestItemForm()
    {
        Auth::logout();
        $response = $this->get(route('testitems.create'));

        $response->assertRedirect(route('login'));
    }


    public function testALoggedInUserCanCreateATestItem()
    {
        $response = $this->post(route('testitems.store'), $this->_data());

        $this->assertCount(1, TestItem::all());

        $data = Arr::except($this->_data(), 'options');

        $this->assertDatabaseHas('test_items', $data);

        $testitem = TestItem::first();

        $this->assertTrue(Str::isUuid($testitem->uuid));
        $this->assertEquals($this->_data()['options'], $testitem->options);

        $response->assertSessionHas('success');
        $response->assertRedirect(route('testitems.show', $testitem));

        $redirect = $this->followRedirects($response);

        $redirect->assertViewIs('test-items.show');
        $redirect->assertViewHas('testitem', $testitem);
    }

    public function testCompetencyIdIsRequiredWhenCreatingATestItem()
    {
        $data = Arr::except($this->_data(), ['competency_uuid']);

        $response = $this->post(route('testitems.store'), $data);

        $response->assertSessionHasErrors('competency_uuid');
    }

    public function testCompetencyUuidShouldBeAUuidWhenCreatingATestItem()
    {
        $competency_uuid = 'abc';

        $data = array_merge($this->_data(), compact('competency_uuid'));

        $response = $this->post(route('testitems.store'), $data);

        $response->assertSessionHasErrors('competency_uuid');
    }

    public function testTypeIsRequiredWhenCreatingATestItem()
    {
        $response = $this->post(route('testitems.store'), Arr::except($this->_data(), ['type']));

        $response->assertSessionHasErrors('type');
    }

    public function testTypeIsValidWhenCreatingATestItem()
    {
        $response = $this->post(route('testitems.store'), array_merge($this->_data(), ['type' => 'A']));

        $response->assertSessionHasErrors('type');
    }

    public function testQuestionIsRequiredWhenCreatingATestItem()
    {
        $response = $this->post(route('testitems.store'), Arr::except($this->_data(), ['question']));

        $response->assertSessionHasErrors('question');
    }

    public function testQuestionMustNotExceedMaxCharactersWhenCreatingATestItem()
    {
        $question = $this->faker->paragraph(20);

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('question')));

        $response->assertSessionHasErrors('question');
    }

    public function testOptionsAreRequiredWhenCreatingATestItem()
    {
        $response = $this->post(route('testitems.store'), Arr::except($this->_data(), ['options']));

        $response->assertSessionHasErrors('options');
    }

    public function testAnOptionCannotExceedMaxCharactersIfTypeIsMultipleChoiceWhenCreatingATestItem()
    {
        $type = 'M';
        $options[0] = $this->faker->paragraph(20);

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('type', 'options')));

        $response->assertSessionHasErrors('options');
    }

    public function testAnswerIsRequiredWhenCreatingATestItem()
    {
        $response = $this->post(route('testitems.store'), Arr::except($this->_data(), ['answer']));

        $response->assertSessionHasErrors('answer');
    }

    public function testAnswerMustBeOneOftheProvidedOptionsIfTypeIsMultipleChoiceWhenCreatingATestItem()
    {
        $type = 'M';
        $answer = $this->faker->word;

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('type', 'answer')));

        $response->assertSessionHasErrors('answer');
    }

    public function testAnswerMustNotExceedMaxCharsIfTypeIsIdentificationWhenCreatingATestItem()
    {
        $type = 'I';
        $answer = $this->faker->paragraph(20);

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('type', 'answer')));

        $response->assertSessionHasErrors('answer');
    }

    public function testAnswerMustBeTrueOrFalseOnlyIfTypeIsTrueOrFalseWhenCreatingATestItem()
    {
        $type = 'T';
        $answer = $this->faker->word;

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('type', 'answer')));

        $response->assertSessionHasErrors('answer');
    }

    public function testTimeoutIsRequiredWhenCreatingATestItem()
    {
        $response = $this->post(route('testitems.store'), Arr::except($this->_data(), ['timeout']));

        $response->assertSessionHasErrors('timeout');
    }

    public function testTimeoutMustBeNumericWhenCreatingATestItem()
    {
        $timeout = $this->faker->randomLetter;

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('timeout')));

        $response->assertSessionHasErrors('timeout');
    }

    public function testTimeoutMustNotExceedMaximumValueWhenCreatingATestItem()
    {
        $timeout = 1000;

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('timeout')));

        $response->assertSessionHasErrors('timeout');
    }

    public function testTimeoutMustBeAtLeastMinimumWhenCreatingATestItem()
    {
        $timeout = 1;

        $response = $this->post(route('testitems.store'), array_merge($this->_data(), compact('timeout')));

        $response->assertSessionHasErrors('timeout');
    }

    public function testAGuestCannotCreateATestItem()
    {
        Auth::logout();
        $response = $this->post(route('testitems.store'), $this->_data());

        $response->assertRedirect(route('login'));

        $this->assertCount(0, TestItem::all());
    }

    // public function testOnlyAnAuthorizedUserCanUpdateATestItem()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAs($user)->post(route('testitems.store'), $this->_data());

    //     $update = ['type' = 'T'];

    //     $this->
    // }
}
