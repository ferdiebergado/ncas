<?php

namespace App\Services;

use App\Repositories\CompetencyCachedRepository;
use App\Support\ExportFactory;

class CompetencyService extends AbstractBaseService
{
    protected $repository;
    protected $exportFactory;

    public function __construct(CompetencyCachedRepository $competencyCachedRepository, ExportFactory $exportFactory)
    {
        $this->repository = $competencyCachedRepository;
        $this->exportFactory = $exportFactory;
    }

    /**
     * Export the data
     *
     * @param array $data The validated request data.
     * @return void
     */
    public function export($data, $queryClass)
    {
        $exporter = $this->exportFactory->getExporter($data['export'], true);

        if ($data['export'] === 'excel') {
            return $exporter->export($queryClass, $data);
        }

        return $exporter->export(self::class, $data);
    }

    public function getFilters(array $validated)
    {
        $id = null;
        $level_id = null;
        $category_id = null;
        $title = $validated['title'] ?? '';

        if (isset($validated['id'])) {
            $id = (int) $validated['id'];
        }

        if (isset($validated['level_id'])) {
            $level_id = (int) $validated['level_id'];
        }

        if (isset($validated['category_id'])) {
            $category_id = (int) $validated['category_id'];
        }

        return compact('id', 'title', 'level_id', 'category_id');
    }
}
