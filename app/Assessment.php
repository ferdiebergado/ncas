<?php

namespace App;

use App\Application;

final class Assessment extends AbstractBaseModel
{
    public function assessmentable()
    {
        return $this->morphTo();
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }
}
