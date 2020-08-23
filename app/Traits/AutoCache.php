<?php

namespace App\Traits;

use App\Helpers\UsesSoftDeletes;
use Illuminate\Support\Facades\Cache;

trait AutoCache
{
    protected static function bootAutoCache()
    {
        static::saved(function ($model) {
            static::flushTagCache($model);
        });

        static::deleted(function ($model) {
            static::flushTagCache($model);
        });

        if (UsesSoftDeletes::usingSoftDeletes()) {
            static::restored(function ($model) {
                static::flushTagCache($model);
            });
        }
    }

    /**
     * Bust the cache for the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    protected static function flushTagCache($model)
    {
        $tag = $model->getTable();
        $cache = Cache::tags($tag);
        $cache->flush();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return Cache::tags($this->getTable())->remember($value, now()->addMinutes(config('custom.cache.timeout')), function () use ($value) {
            $id = get_class($this) . '_id';
            return $this->where($id, $value)->firstOrFail();
        });
    }
}
