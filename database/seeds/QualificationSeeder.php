<?php

use App\Services\QualificationService;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    private $qualificationService;

    public function __construct(QualificationService $qualificationService)
    {
        $this->qualificationService = $qualificationService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qualification = [
            'title' => 'Agricultural Crops Production NC III',
            'level_id' => 3,
            'category_id' => 1,
            'competencies' => [
                [
                    'level' => 1,
                    'title' => 'Prepare Land for Agricultural Crops Production'
                ],
                [
                    'level' => 2,
                    'title' => 'Implement a Post Harvest Program'
                ]
            ]
        ];

        $this->qualificationService->create($qualification);

        $qualification2 = [
            'title' => 'Tailoring NC II',
            'level_id' => 2,
            'category_id' => 4
        ];

        $this->qualificationService->create($qualification2);
    }
}
