<?php

namespace App\Repositories;

use Closure;
use App\AbstractBaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var \App\AbstractBaseModel
     */
    protected $model;
    protected $cacheKey;
    protected $cache;
    protected $timeout;

    /**
     * BaseRepository constructor.
     * @param \App\AbstractBaseModel $model
     */
    public function __construct(AbstractBaseModel $model)
    {
        $this->model = $model;
        $this->cache = Cache::tags($this->model->getTable());
        $minutes = Config::get('custom.cache.timeout', 10);
        $this->timeout = now()->addMinutes($minutes);
    }

    public function getCacheKey()
    {
        return $this->cacheKey;
    }

    public function getCacheTimeout()
    {
        return $this->timeout;
    }

    protected function getQuery(): Builder
    {
        return $this->model->query();
    }

    public function filter($filters, $orderBy, $dir)
    {
        // fields to filter
        $filtered = [];

        // cache key for the filtered fields
        $cacheFields = '';

        foreach ($filters as $field => $value) {
            if (!empty($value)) {
                $cacheFields .= '.' . $field . '.' . $value;
                $filtered = array_merge($filtered, [$field => $value]);
            }
        }

        $this->cacheKey .= $cacheFields;

        // Build the query
        $query = $this->getQuery();

        // filter
        $query->when($filtered, function ($q, $filtered) {
            foreach (array_keys($filtered) as $field) {
                $value = $filtered[$field];
                if (is_string($value)) {
                    $q->where($field, 'LIKE', "%$value%");
                } else {
                    $q->where($field, $value);
                }
            }
            return $q;
        });

        // sort
        $query->when($orderBy, function ($q, $orderBy) use ($dir) {
            $this->cacheKey .= '.orderby.' . $orderBy . '.dir.' . $dir;
            return $q->orderBy($orderBy, $dir);
        });

        $this->model = $query;

        return $this->model;
    }

    public function paginate($perPage, $page, $from, $to): LengthAwarePaginator
    {
        $this->cacheKey .= '.perpage.' . $perPage . '.page.' . $page . '.from.' . $from . '.to.' . $to;
        return $this->cache->remember($this->cacheKey, $this->timeout, function () use ($perPage) {
            return $this->model->paginate($perPage);
        });
    }

    public function get($columns = ['*']): Collection
    {
        $this->cacheKey .= '.all.';
        foreach ($columns as $col) {
            $this->cacheKey .= $col;
        }
        return $this->cache->remember($this->cacheKey, $this->timeout, function () use ($columns) {
            return $this->model->get(($columns));
        });
    }

    public function count()
    {
        $this->cacheKey .= '.count';
        return $this->cache->remember($this->cacheKey, $this->timeout, function () {
            return $this->model->count();
        });
    }

    public function orderBy($field, $dir = 'asc')
    {
        return $this->model->orderBy($field, $dir);
    }

    public function cacheRemember($key, Closure $callback)
    {
        return $this->cache->remember($key, $this->timeout, $callback);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
