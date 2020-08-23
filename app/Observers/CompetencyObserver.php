<?php

namespace App\Observers;

use App\Competency;
use App\Traits\ModelCoder;
// use App\Traits\Slugger;
use Illuminate\Support\Str;

class CompetencyObserver
{
    use ModelCoder;

    public function creating(Competency $competency)
    {
        // competency id
        $qualification = explode('-', $competency->qualification_id);
        $qualificationCode = $qualification[0] . '-' . $qualification[1];
        $competency->competency_id = Str::upper($qualificationCode . '-COC' . $competency->level);

        // slug
        // $toSlug = $competency->title . ' ' . $competency->level_id;
        // $competency->slug = $this->slugify($toSlug);
    }

    /**
     * Handle the competency "created" event.
     *
     * @param  \App\Competency  $competency
     * @return void
     */
    public function created(Competency $competency)
    {
        //
    }

    /**
     * Handle the competency "updated" event.
     *
     * @param  \App\Competency  $competency
     * @return void
     */
    public function updated(Competency $competency)
    {
        //
    }

    /**
     * Handle the competency "deleted" event.
     *
     * @param  \App\Competency  $competency
     * @return void
     */
    public function deleted(Competency $competency)
    {
        //
    }

    /**
     * Handle the competency "restored" event.
     *
     * @param  \App\Competency  $competency
     * @return void
     */
    public function restored(Competency $competency)
    {
        //
    }

    /**
     * Handle the competency "force deleted" event.
     *
     * @param  \App\Competency  $competency
     * @return void
     */
    public function forceDeleted(Competency $competency)
    {
        //
    }
}
