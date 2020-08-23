<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Exports\TestitemQueryExport;
use App\Http\Requests\TestitemIndexRequest;
use App\Services\TestitemService;

class TestitemExportController extends Controller
{
    public function __invoke(TestitemIndexRequest $testitemIndexRequest, TestitemService $testitemService)
    {
        $validated = $testitemIndexRequest->validated();

        return $testitemService->export($validated, TestitemQueryExport::class);
    }
}
