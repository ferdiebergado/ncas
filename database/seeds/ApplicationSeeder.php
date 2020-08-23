<?php

use App\Application;
use App\Qualification;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $application = [
            'last_name' => 'Catacutan',
            'first_name' => 'Romeo',
            'middle_name' => 'Dimaandal',
            'sex' => 'M',
            'mobile' => '9876543210',
            'email' => 'awooo@lagim.com',
            'qualification_id' => Qualification::first()->qualification_id
        ];

        Application::create($application);
    }
}
