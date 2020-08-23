<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Creating
{
    /**
     * When the model is being created.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function handle($model)
    {
        if (!$model->isUserstamping() || !Auth::check()) {
            return;
        }

        if (is_null($model->created_by)) {
            $model->created_by = Auth::user()->uuid;
        }

        if (is_null($model->updated_by)) {
            $model->updated_by = Auth::user()->uuid;
        }
    }
}
