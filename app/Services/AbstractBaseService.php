<?php

namespace App\Services;

use App\Repositories\CompetencyCachedRepository;
use App\Support\ExportFactory;
use Illuminate\Support\Facades\Config;

abstract class AbstractBaseService
{
    protected $repository;
    protected $exportFactory;

    public function __construct(CompetencyCachedRepository $competencyCachedRepository, ExportFactory $exportFactory)
    {
        $this->repository = $competencyCachedRepository;
        $this->exportFactory = $exportFactory;
    }

    public function getData($validated, $isPaginated = false, $columns = ['*'])
    {
        $page = null;
        $perPage = Config::get('custom.pagination.per_page', 10);
        $from = null;
        $to = null;

        if (isset($validated['page'])) {
            $page = (int) $validated['page'];
        }

        if (isset($validated['per_page'])) {
            $perPage = (int) $validated['per_page'];
        }

        if (isset($validated['from'])) {
            $from = (int) $validated['from'];
        }

        if (isset($validated['to'])) {
            $to = (int) $validated['to'];
        }

        $orderBy = $validated['order_by'] ?? '';

        $dir = $validated['dir'] ?? '';

        $filtered = $validated['filter'];

        $filters = $this->getFilters($validated);

        if ($filtered) {
            $this->repository->filter($filters, $orderBy, $dir);
        }

        if ($isPaginated) {
            return $this->repository->paginate($perPage, $page, $from, $to);
        }

        return $this->repository->get($columns);
    }

    abstract public function getFilters(array $validated);

    public function filteredQuery(array $data)
    {
        $orderBy = $data['order_by'];
        $dir = $data['dir'];

        $filters = $this->getFilters($data);
        return $this->repository->filter($filters, $orderBy, $dir);
    }
}
