<?php

namespace App\Support;

use App\Jobs\QueuePDFExport;
use App\Exports\BaseExporter;
use App\Contracts\BatchExportableInterface;

class PDFBatchExporter extends BaseExporter implements BatchExportableInterface
{
    public function export($export, $data)
    {
        QueuePDFExport::dispatch($export, $data, $this->basename, request()->user());
    }
}
