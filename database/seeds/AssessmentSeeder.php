<?php

use App\Application;
use App\Assessment;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $application = factory(Application::class)->create();

        $application->assessments()->save(new Assessment);
    }
}
