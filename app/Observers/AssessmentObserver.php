<?php

namespace App\Observers;

use App\Assessment;
use Illuminate\Support\Str;

class AssessmentObserver
{
    /**
     * Handle the assessment "created" event.
     *
     * @param  \App\Assessment  $assessment
     * @return void
     */
    public function creating(Assessment $assessment)
    {
        $id = Assessment::max('id') ?? 0;
        $year = now()->year;
        $month = now()->month;

        if ($assessment->assessmentable_type === 'qualification') {
            $array = explode('-', $assessment->assessmentable_id);
            $qualificationCode = last($array);
        } else {
            $qualificationCode = $assessment->assessmentable_id;
        }

        $prefix = $year . '-' . $month . '-' . $qualificationCode;
        $hash = Str::random(8);
        $assessment->assessment_id = Str::upper($prefix . '-' . $hash . '-' . ++$id);
    }

    /**
     * Handle the assessment "created" event.
     *
     * @param  \App\Assessment  $assessment
     * @return void
     */
    public function created(Assessment $assessment)
    {
        //
    }

    /**
     * Handle the assessment "updated" event.
     *
     * @param  \App\Assessment  $assessment
     * @return void
     */
    public function updated(Assessment $assessment)
    {
        //
    }

    /**
     * Handle the assessment "deleted" event.
     *
     * @param  \App\Assessment  $assessment
     * @return void
     */
    public function deleted(Assessment $assessment)
    {
        //
    }

    /**
     * Handle the assessment "restored" event.
     *
     * @param  \App\Assessment  $assessment
     * @return void
     */
    public function restored(Assessment $assessment)
    {
        //
    }

    /**
     * Handle the assessment "force deleted" event.
     *
     * @param  \App\Assessment  $assessment
     * @return void
     */
    public function forceDeleted(Assessment $assessment)
    {
        //
    }
}
