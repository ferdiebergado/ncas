<?php

namespace App\Observers;

use App\Application;
// use App\Traits\Slugger;
use App\Traits\ModelCoder;
use Illuminate\Support\Str;

class ApplicationObserver
{
    use ModelCoder;

    public function creating(Application $application)
    {
        // application id
        $id = Application::max('id') ?? 0;
        $year = now()->year;
        $month = now()->month;

        if (isset($application->competencies)) {
            // $competency = explode('-', $application->competency_id);
            // $qualificationCode = $competency[0] . $competency[1] . '-' . $competency[2];
            $application->coc_count = count($application->competencies);
            unset($application->competencies);
        }

        $qualification = explode('-', $application->qualification_id);
        $qualificationCode = $qualification[0] . '-' . $qualification[1];

        $prefix = $year . '-' . $month . '-' . $qualificationCode;
        $hash = Str::random(8);
        $application->application_id = Str::upper($prefix . '-' . $hash . '-' . ++$id);

        // slug
        // $toSlug = $application->last_name . ' ' . $application->first_name . ' ' . $application->middle_name;
        // $application->slug = $this->slugify($toSlug);
    }

    /**
     * Handle the application "created" event.
     *
     * @param  \App\application  $application
     * @return void
     */
    public function created(Application $application)
    {
        //
    }

    /**
     * Handle the application "updated" event.
     *
     * @param  \App\application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        //
    }

    /**
     * Handle the application "deleted" event.
     *
     * @param  \App\application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        //
    }

    /**
     * Handle the application "restored" event.
     *
     * @param  \App\application  $application
     * @return void
     */
    public function restored(Application $application)
    {
        //
    }

    /**
     * Handle the application "force deleted" event.
     *
     * @param  \App\application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}
