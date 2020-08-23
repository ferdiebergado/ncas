<?php

namespace App\Http\View\Composers;

use App\Competency;
use Illuminate\View\View;

class CompetenciesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $path = '/api/competencies';

        $view->with('path', $path);

        $columns = [
            [
                'name' => 'id',
                'label' => 'ID',
                'width' => '10%',
                'centered' => true
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'width' => '25%'
            ],
            [
                'name' => 'level_id',
                'label' => 'Level',
                'width' => '10%',
                'values' => Competency::LEVELS,
                'centered' => true
            ],
            [
                'name' => 'category_id',
                'label' => 'Category',
                'width' => '25%',
                'values' => Competency::CATEGORIES
            ]
        ];

        $view->with('columns', json_encode($columns));
        $view->with('route', $path);
    }
}
