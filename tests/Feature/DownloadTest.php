<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DownloadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDownload()
    {
        $file = 'Laravel-export-3FWFCTzw1596940416.xlsx';
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('download', compact('file')));

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDownloadFailsWithLongFilename()
    {
        $file = Str::random(51);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('download', compact('file')));

        $response->assertSessionHasErrors('file');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDownloadFailsWhenFileIsMissing()
    {
        $file = '';
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('download', compact('file')));

        $response->assertSessionHasErrors('file');
    }
}
