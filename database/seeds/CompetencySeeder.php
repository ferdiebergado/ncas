<?php

use App\Competency;
use App\Qualification;
use Illuminate\Database\Seeder;

class CompetencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $competency1 = [
            'level' => 1,
            'title' => 'Service Body Management and Under Chassis Electronic Control System',
            'qualification_id' => Qualification::first()->qualification_id
        ];

        $this->save($competency1);

        $competency2 = [
            'level' => 1,
            'title' => 'Deliver Training Session',
            'qualification_id' => Qualification::find(2)->qualification_id
        ];

        $this->save($competency2);

        // $competency3 = [
        //     'level' => 1,
        //     'title' => 'Prepare Land for Agricultural Crops Production',
        //     'qualification_id' => Qualification::inRandomOrder()->first()->qualification_id
        // ];

        // $this->save($competency3);
    }

    private function save($competency)
    {
        $count = Competency::where('level', $competency['level'])->where('title', $competency['title'])->where('qualification_id', $competency['qualification_id'])->count();

        if ($count === 0) {
            Competency::create($competency);
        }
    }
}
