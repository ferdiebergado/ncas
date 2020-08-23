<?php

namespace App\Observers;

use App\Traits\ModelCoder;
use App\Traits\Slugger;

class BaseObserver
{
    use ModelCoder, Slugger;
}
