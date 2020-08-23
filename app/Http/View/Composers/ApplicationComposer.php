<?php

namespace App\Http\View\Composers;

use App\Qualification;
use Illuminate\View\View;

class ApplicationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $sex = [
            [
                'value' => 'M',
                'text' => 'Male'
            ],
            [
                'value' => 'F',
                'text' => 'Female'
            ]
        ];

        // $qualifications = Qualification::with('competencies')->orderBy('title')->get(['qualification_id', 'title']);

        // $competencyApi = '/api/competencies';

        $steps = [
            [
                'marker' => 1,
                'title' => 'Personal Information'
            ],
            [
                'marker' => 2,
                'title' => 'Choose Qualification'
            ],
            [
                'marker' => 3,
                'title' => 'Payment'
            ],
            [
                'marker' => 4,
                'title' => 'Finish'
            ]
        ];

        $view->with('sex', $sex);
        // $view->with('qualifications', $qualifications);
        // $view->with('competencyApi', $competencyApi);
        $view->with('steps', $steps);
    }
}
