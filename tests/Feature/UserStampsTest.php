<?php

namespace Tests\Feature;

use App\Competency;
use App\User;
use App\TestItem;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\TestItem\TestItemAbstractBaseTestCase;

class UserStampsTest extends TestItemAbstractBaseTestCase
{
    public function testUserStampsIsSetWhenALoggedInUserCreatesATestItem()
    {
        $this->createTestItem();

        $this->assertTrue(isset($this->testitem->created_by));
        $this->assertEquals($this->testitem->created_by, $this->user->uuid);
        $this->assertTrue(isset($this->testitem->updated_by));
        $this->assertEquals($this->testitem->updated_by, $this->user->uuid);
    }

    public function testUserStampIsUpdatedWhenALoggedInUserUpdatesATestItem()
    {
        $users = factory(User::class, 3)->create();

        $user1 = $users->first();

        $user2 = $users->last();

        Auth::logout();

        $this->actingAs($user1);

        $this->createTestItem();

        $this->assertTrue(isset($this->testitem->updated_by));
        $this->assertEquals($this->testitem->updated_by, $user1->uuid);

        Auth::logout();

        $update = ['competency_uuid' => Competency::inRandomOrder()->first()->uuid];

        $data = array_merge($this->_data(), $update);

        $this->actingAs($user2)->put(route('testitems.update', $this->testitem), $data);

        $this->assertDatabaseHas('test_items', $update);

        $this->assertTrue(isset($this->testitem->fresh()->updated_by));
        $this->assertEquals($this->testitem->fresh()->updated_by, $user2->uuid);
    }
}
