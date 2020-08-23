<?php

namespace App\Http\Controllers;

use App\Competency;
use App\Support\ExportFactory;

class CompetencyExportController extends Controller
{
    /**
     * Export a competency.
     *
     * @param  \App\Competency  $competency
     * @param \App\Support\ExportFactory $exportFactory
     * @return \Illuminate\Http\Response
     */
    public function single(Competency $competency, ExportFactory $exportFactory)
    {
        $exporter = $exportFactory->getExporter('pdf');

        return $exporter->export('competency.export-single', $competency);
    }
}
