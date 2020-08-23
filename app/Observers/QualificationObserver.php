<?php

namespace App\Observers;

use App\Qualification;
// use Illuminate\Support\Str;

class QualificationObserver extends BaseObserver
{
    /**
     * Handle the qualification "creating" event.
     *
     * @param  \App\Qualification  $qualification
     * @return void
     */
    public function creating(Qualification $qualification)
    {
        // qualification_id
        $categoryCode = $qualification::CATEGORIES[$qualification->category_id]['code'];
        $qualification->qualification_id = $categoryCode . '-' .  $this->codify($qualification->title) . $qualification->level_id;

        // slug
        // $qualification->slug = $this->slugify($qualification->title . $qualification->level_id);
    }

    /**
     * Handle the qualification "created" event.
     *
     * @param  \App\Qualification  $qualification
     * @return void
     */
    public function created(Qualification $qualification)
    {
        //
    }

    /**
     * Handle the qualification "updated" event.
     *
     * @param  \App\Qualification  $qualification
     * @return void
     */
    public function updated(Qualification $qualification)
    {
        //
    }

    /**
     * Handle the qualification "deleted" event.
     *
     * @param  \App\Qualification  $qualification
     * @return void
     */
    public function deleted(Qualification $qualification)
    {
        //
    }

    /**
     * Handle the qualification "restored" event.
     *
     * @param  \App\Qualification  $qualification
     * @return void
     */
    public function restored(Qualification $qualification)
    {
        //
    }

    /**
     * Handle the qualification "force deleted" event.
     *
     * @param  \App\Qualification  $qualification
     * @return void
     */
    public function forceDeleted(Qualification $qualification)
    {
        //
    }
}
