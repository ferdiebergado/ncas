<?php

namespace App\Services;

use App\Repositories\TestitemCachedRepository;
use App\Support\ExportFactory;

class TestitemService extends AbstractBaseService
{
    protected $repository;
    protected $exportFactory;

    public function __construct(TestitemCachedRepository $testitemCachedRepository, ExportFactory $exportFactory)
    {
        $this->repository = $testitemCachedRepository;
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
        $type = $validated['type'] ?? '';
        $competency_id = null;
        $question = $validated['question'] ?? '';
        $options = $validated['options'] ?? '';
        $answer = $validated['answer'] ?? '';
        $timeout = null;

        if (isset($validated['id'])) {
            $id = (int) $validated['id'];
        }

        if (isset($validated['type_id'])) {
            $type_id = (int) $validated['type_id'];
        }

        if (isset($validated['competency_id'])) {
            $competency_id = (int) $validated['competency_id'];
        }

        if (isset($validated['timeout'])) {
            $timeout = (int) $validated['timeout'];
        }

        return compact('id', 'type', 'competency_id', 'question', 'options', 'answer', 'timeout');
    }
}
