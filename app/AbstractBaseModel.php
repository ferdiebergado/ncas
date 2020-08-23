<?php

namespace App;

use App\Traits\AutoCache;
use App\Traits\UserStamps;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractBaseModel extends Model
{
    use AutoCache;

    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function getPathAttribute()
    {
        $model = get_class($this);

        $resource = Str::plural($model);
        $id = $model . '_id';

        return '/' . Str::lower(Str::afterLast($resource, '\\')) . '/' . $this->attributes[$id];
    }
}
