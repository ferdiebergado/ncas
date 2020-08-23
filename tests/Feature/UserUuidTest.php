<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUuidTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test a new user has a uuid.
     *
     * @return void
     */
    public function testANewUserHasAUuid()
    {
        $pw = $this->faker->password;
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $pw,
            'password_confirmation' => $pw
        ];

        $this->post(route('register'), $user);

        $u = User::first();

        $this->assertTrue(isset($u->uuid));
        $this->assertTrue(Str::isUuid($u->uuid));
    }
}
