<?php

namespace Tests\Browser\Competency;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class CompetencyBaseBrowserTestCase extends DuskTestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    protected function _data()
    {
        return [
            'title' => 'Small Engine Disassembly',
            'level_id' => 1,
            'category_id' => 2
        ];
    }
}
