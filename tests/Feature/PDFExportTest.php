<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PDFExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test pdf export.
     *
     * @return void
     */
    public function testPDFExport()
    {
        $user = factory(User::class)->create();
        $url = '/competencies/export?search=agnis&category_id=1&level_id=1&order_by=id&dir=asc&filter=1&batch=1&export=pdf';

        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(200);
    }
}
