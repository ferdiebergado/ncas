<?php

namespace App\Services;

use App\Repositories\BaseRepository;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
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
}
