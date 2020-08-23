<?php

namespace Tests\Browser\Application;

use App\Qualification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ApplicationCreateTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
        $a = [
            'last_name' => 'Catacutan',
            'first_name' => 'Romeo',
            'middle_name' => 'Dimaandal',
            'sex' => 'M',
            'mobile' => '9876543210',
            'email' => 'awooo@lagim.com',
            'qualification_id' => Qualification::first()->qualification_id
        ];
            $browser->visit(route('applications.create'))
            ->type('last_name', $a['last_name'])
                    ->assertSee('Laravel');
        });
    }
}
