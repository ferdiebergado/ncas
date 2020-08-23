<?php

namespace Tests\Feature\TestItem;

use App\TestItem;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\TestItem\TestItemAbstractBaseTestCase;

class TestItemReadTest extends TestItemAbstractBaseTestCase
{
    public function testATestItemCanBeViewed()
    {
        $this->createTestItem();

        $response = $this->get(route('testitems.show', $this->testitem));

        $response->assertViewIs('test-items.show');
        $response->assertViewHas('testitem', $this->testitem);
    }

    public function testALoggedInUserCanViewTheTestItemList()
    {
        $this->createTestItem();

        $testitems = TestItem::all();

        $response = $this->get(route('testitems.index'));

        $response->assertViewIs('test-items.index');
        $response->assertViewHas('testitems', $testitems);
    }

    public function testAGuestCannotViewTheTestItemList()
    {
        $this->createTestItem();

        Auth::logout();

        $response = $this->get(route('testitems.index'));

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
