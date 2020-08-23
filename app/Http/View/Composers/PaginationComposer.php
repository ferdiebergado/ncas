<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Config;

class PaginationComposer
{
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
