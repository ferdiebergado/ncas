<?php

namespace App;

use App\Assessment;

final class Application extends AbstractBaseModel
{
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'application_id', 'application_id');
    }
}
