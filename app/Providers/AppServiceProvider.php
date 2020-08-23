<?php

namespace App\Providers;

use App\Application;
use App\Assessment;
use App\Competency;
use App\Observers\ApplicationObserver;
use App\Observers\AssessmentObserver;
use App\Observers\CompetencyObserver;
use App\Observers\QualificationObserver;
use App\Qualification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Application::observe(ApplicationObserver::class);
        Qualification::observe(QualificationObserver::class);
        Competency::observe(CompetencyObserver::class);
        Assessment::observe(AssessmentObserver::class);
    }
}
