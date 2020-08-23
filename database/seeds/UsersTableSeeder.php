<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'ferdie',
            'email' => 'ferdiebergado@gmail.com',
            'password' => Hash::make('alingfely'),
            'email_verified_at' => now()
        ];

        User::create($user);
    }
}
