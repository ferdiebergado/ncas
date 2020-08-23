<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'competency.*',
            'App\Http\View\Composers\CompetencyComposer'
        );

        View::composer(
            ['competency.index', 'test-items.create'],
            'App\Http\View\Composers\CompetenciesComposer'
        );

        View::composer(
            ['test-items.create', 'test-items.index'],
            'App\Http\View\Composers\TestItemsComposer'
        );

        View::composer(
            'competencies.index',
            'App\Http\View\Composers\PaginationComposer'
        );

        View::composer(
            'application.create',
            'App\Http\View\Composers\ApplicationComposer'
        );
    }
}
