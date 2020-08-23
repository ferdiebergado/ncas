<?php

namespace App\Http\Controllers\API;

use App\Exports\CompetencyQueryExport;
use App\Services\CompetencyService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompetencyIndexRequest;

class CompetencyExportController extends Controller
{
    public function __invoke(CompetencyIndexRequest $competencyIndexRequest, CompetencyService $competencyService)
    {
        $validated = $competencyIndexRequest->validated();

        return $competencyService->export($validated, CompetencyQueryExport::class);
    }
}
