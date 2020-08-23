<?php

namespace App\Http\View\Composers;

use App\Competency;
use Illuminate\View\View;
use Illuminate\Support\Facades\Config;

class CompetencyComposer
{
    /**
     * The competency model.
     *
     * @var \App\Competency
     */
    protected $competency;

    /**
     * Create a new competency composer.
     *
     * @param  Competency  $competencies
     * @return void
     */
    public function __construct(Competency $competency)
    {
        // Dependencies automatically resolved by service container...
        $this->competency = $competency;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $pages = Config::get('custom.pagination.per_page_list');

        $view->with('pages', json_encode($pages));
    }
}
