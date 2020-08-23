<?php

namespace Tests\Feature;

use App\User;
use App\Login;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginRecordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if a successful login is recorded in the database
     *
     * @return void
     */
    public function testLogASuccessfulLogin()
    {
        $user = factory(User::class)->create();

        $creds = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->post(route('login'), $creds);

        $request = app()->make('request');

        $this->assertCount(1, Login::all());

        $data = [
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        $this->assertDatabaseHas('logins', $data);

        $this->assertTrue(isset($user->fresh()->last_login_at));

        $login = Login::first();

        $this->assertEquals($user->fresh()->last_login_at, $login->created_at);

        $this->assertTrue(isset($user->fresh()->last_login_ip));
        $this->assertEquals($user->fresh()->last_login_ip, $login->ip);

        $this->assertTrue(isset($user->fresh()->last_login_user_agent));
        $this->assertEquals($user->fresh()->last_login_user_agent, $login->user_agent);
    }
}
