<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Updating
{
    /**
     * When the model is being updated.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function handle($model)
    {
        if (!$model->isUserstamping() || !Auth::check()) {
            return;
        }

        $model->updated_by = Auth::user()->uuid;
    }
}
