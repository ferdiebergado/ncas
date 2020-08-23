<?php

namespace App\Support;

use PDF;
use App\Contracts\ExportableInterface;

class PrintExporter implements ExportableInterface
{
    public function export($view, $data)
    {
        $pdf = PDF::loadView('competency.print', compact('data'));

        return $pdf->download('competencies-export.pdf');
    }
}
