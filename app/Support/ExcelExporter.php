<?php

namespace App\Support;

use Illuminate\Support\Facades\App;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Contracts\BatchExportableInterface;
use App\Exports\BaseExporter;

class ExcelExporter extends BaseExporter implements BatchExportableInterface
{
    public function export($class, $data)
    {
        $filename = $this->basename . '.xlsx';
        $export = App::make($class, compact('data'));

        $export
            ->queue($filename)
            ->chain([new NotifyUserOfCompletedExport(request()->user(), $filename)]);
    }
}
