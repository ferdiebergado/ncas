<?php

namespace App;

use App\Assessment;
use App\Competency;

final class Qualification extends AbstractBaseModel
{
    /**
     * Qualification levels
     *
     * @var array
     */
    public const LEVELS = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV'
    ];

    /**
     * Qualification categories
     *
     * @var array
     */
    public const CATEGORIES = [
        1 => [
            'name' => 'Agriculture',
            'code' => 'AGRI'
        ],
        2 => [
            'name' => 'Entrepreneurship',
            'code' => 'ENTREP'
        ],
        3 => [
            'name' => 'Industrial Arts',
            'code' => 'IA'
        ],
        4 => [
            'name' => 'Home Economics',
            'code' => 'HE'
        ],
        5 => [
            'name' => 'Information Communication Technology',
            'code' => 'ICT'
        ],
        6 => [
            'name' => 'Trainers Methodology',
            'code' => 'TM'
        ]
    ];

    public function competencies()
    {
        return $this->hasMany(Competency::class, 'qualification_id', 'qualification_id');
    }

    public function assessments()
    {
        return $this->morphMany(Assessment::class, 'assessmentable', null, null, 'qualification_id');
    }
}
