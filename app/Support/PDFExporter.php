<?php

namespace App\Support;

use App\Contracts\ExportableInterface;
use App\Exports\BaseExporter;
use PDF;

class PDFExporter extends BaseExporter implements ExportableInterface
{
    public function export(string $view, $data)
    {
        $pdf = PDF::loadView($view, compact('data'));

        return $pdf->download($this->basename . '.pdf');
    }
}
