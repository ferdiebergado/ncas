<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    protected static function bootUuidTrait()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::orderedUuid();
        });
    }

    // public function getIncrementing()
    // {
    //     return false;
    // }

    // public function getKeyType()
    // {
    //     return 'string';
    // }
}
