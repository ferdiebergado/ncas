<?php

namespace Tests\Feature;

use App\TestItem;
use Illuminate\Support\Str;
use Tests\Feature\TestItem\TestItemAbstractBaseTestCase;

class UuidTraitTest extends TestItemAbstractBaseTestCase
{
    public function testUuidFieldIsAUuid()
    {
        $this->post(route('testitems.store'), $this->_data());

        $testitem = TestItem::first();

        $this->assertTrue(Str::isUuid($testitem->uuid));
    }
}
