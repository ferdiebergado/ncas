<?php

namespace App\Support;

use App\Support\PDFBatchExporter;

class ExportFactory
{
    public function getExporter($type, $batch = false)
    {
        switch ($type) {
            case 'pdf':
                if ($batch) {
                    return new PDFBatchExporter();
                }
                return new PDFExporter();
                break;
            case 'excel':
                return new ExcelExporter();
                break;
            case 'print':
                return new PrintExporter;
                break;
        }
    }
}
