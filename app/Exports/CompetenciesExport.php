<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CompetenciesExport implements FromCollection, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }
}
