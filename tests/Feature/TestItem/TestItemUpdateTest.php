<?php

namespace Tests\Feature\TestItem;

use App\Competency;
use App\User;
use App\TestItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\TestItem\TestItemAbstractBaseTestCase;

class TestItemUpdateTest extends TestItemAbstractBaseTestCase
{
    public function testAGuestCannotViewTheEditTestItemForm()
    {
        $this->createTestItem();

        Auth::logout();

        $response = $this->get(route('testitems.edit', $this->testitem));

        $response->assertRedirect(route('login'));
    }

    public function testOnlyALoggedInUserCanViewTheEditTestItemForm()
    {
        $this->createTestItem();
        $response = $this->get(route('testitems.edit', $this->testitem));

        $response->assertViewIs('test-items.edit');

        $response->assertViewHas('testitem', $this->testitem);
    }

    public function testCanUpdateATestItemCompetency()
    {
        $this->createTestItem();

        $update = ['competency_uuid' => Competency::inRandomOrder()->first()->uuid];

        $data = array_merge($this->_data(), $update);

        $response = $this->put(route('testitems.update', $this->testitem), $data);

        $this->assertDatabaseHas('test_items', $update);

        $response->assertRedirect(route('testitems.show', $this->testitem));

        $redirect = $this->followRedirects($response);

        $redirect->assertViewIs('test-items.show');

        $redirect->assertViewHas('testitem', $this->testitem->fresh());
    }

    public function testCompetencyIdIsRequiredWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $data = Arr::except($this->_data(), 'competency_uuid');

        $response = $this->put(route('testitems.update', $this->testitem), $data);

        $response->assertSessionHasErrors('competency_uuid');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testCompetencyIdShouldBeNumericWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $competency_uuid = 'abc';

        $data = array_merge($this->_data(), compact('competency_uuid'));

        $response = $this->put(route('testitems.update', $this->testitem), $data);

        $response->assertSessionHasErrors('competency_uuid');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testTypeIsRequiredWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $response = $this->put(route('testitems.update', $this->testitem), Arr::except($this->_data(), 'type'));

        $response->assertSessionHasErrors('type');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testTypeIsValidWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $update = ['type' => '1'];

        $data = array_merge($this->_data(), $update);

        $response = $this->put(route('testitems.update', $this->testitem), $data);

        $response->assertSessionHasErrors('type');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testQuestionIsRequiredWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $response = $this->put(route('testitems.update', $this->testitem), Arr::except($this->_data(), 'question'));

        $response->assertSessionHasErrors('question');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testQuestionMustNotExceedMaxCharactersWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $question = Str::random(300);

        $response = $this->put(route('testitems.update', $this->testitem), array_merge($this->_data(), compact('question')));

        $response->assertSessionHasErrors('question');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testOptionsIsRequiredWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $response = $this->put(route('testitems.update', $this->testitem), Arr::except($this->_data(), 'options'));

        $response->assertSessionHasErrors('options');

        $this->assertEquals($this->_data()['options'], $this->testitem->options);
    }

    public function testAnswerIsRequiredWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $response = $this->put(route('testitems.update', $this->testitem), Arr::except($this->_data(), 'answer'));

        $response->assertSessionHasErrors('answer');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testAnswerMustNotExceedMaxCharsWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $answer = Str::random(300);

        $response = $this->put(route('testitems.update', $this->testitem), array_merge($this->_data(), compact('answer')));

        $response->assertSessionHasErrors('answer');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testTimeoutIsRequiredWhenUpdatingATestItem()
    {
        $this->createTestItem();
        $response = $this->put(route('testitems.update', $this->testitem), Arr::except($this->_data(), 'timeout'));

        $response->assertSessionHasErrors('timeout');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testTimeoutMustBeNumericWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $timeout = 'a';

        $response = $this->put(route('testitems.update', $this->testitem), array_merge($this->_data(), compact('timeout')));

        $response->assertSessionHasErrors('timeout');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testTimeoutMustBeGreaterOrEqualToMinimumValueWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $timeout = 1;

        $response = $this->put(route('testitems.update', $this->testitem), array_merge($this->_data(), compact('timeout')));

        $response->assertSessionHasErrors('timeout');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testTimeoutMustNotExceedMaximumValueWhenUpdatingATestItem()
    {
        $this->createTestItem();

        $timeout = 1000;

        $response = $this->put(route('testitems.update', $this->testitem), array_merge($this->_data(), compact('timeout')));

        $response->assertSessionHasErrors('timeout');

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));
    }

    public function testALoggedInUserCanUpdateATestItemCompetency()
    {
        $this->createTestItem();

        $update = ['competency_uuid' => Competency::inRandomOrder()->first()->uuid];

        $data = array_merge($this->_data(), $update);

        $response = $this->put(route('testitems.update', $this->testitem), $data);

        $this->assertDatabaseHas('test_items', $update);

        $response->assertRedirect(route('testitems.show', $this->testitem));

        $redirect = $this->followRedirects($response);

        $redirect->assertViewIs('test-items.show');

        $redirect->assertViewHas('testitem', $this->testitem->fresh());
    }

    public function testALoggedInUserCanUpdateATestItemType()
    {
        $this->createTestItem();

        $update = ['type' => 'I'];

        $data = array_merge($this->_data(), $update);

        $response = $this->put(route('testitems.update', $this->testitem), $data);

        $this->assertDatabaseHas('test_items', $update);

        $response->assertRedirect(route('testitems.show', $this->testitem));

        $redirect = $this->followRedirects($response);

        $redirect->assertSee($update['type']);
    }

    // public function testOnlyAnAuthorizedUserCanUpdateATestItem()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAs($user)->post(route('testitems.store'), $this->_data());

    //     $update = ['type' = 'T'];

    //     $this->
    // }
}
