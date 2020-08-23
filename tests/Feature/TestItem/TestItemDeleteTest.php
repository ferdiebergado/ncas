<?php

namespace Tests\Feature\TestItem;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TestItemDeleteTest extends TestItemAbstractBaseTestCase
{
    public function testALoggedInUserCanDeleteATestItem()
    {
        $this->createTestItem();

        $response = $this->delete(route('testitems.destroy', $this->testitem));

        $this->assertDatabaseMissing('test_items', Arr::except($this->_data(), 'options'));

        $response->assertRedirect(route('testitems.index'));
    }

    public function testAGuestCannotDeleteATestItem()
    {
        $this->createTestItem();

        Auth::logout();

        $response = $this->delete(route('testitems.destroy', $this->testitem));

        $this->assertDatabaseHas('test_items', Arr::except($this->_data(), 'options'));

        $response->assertRedirect(route('login'));
    }

    // public function testOnlyAnAuthorizedUserCanUpdateATestItem()
    // {
    //     $user = factory(User::class)->create();

    //     $this->actingAs($user)->post(route('testitems.store'), $this->_data());

    //     $update = ['type' = 'T'];

    //     $this->
    // }
}
