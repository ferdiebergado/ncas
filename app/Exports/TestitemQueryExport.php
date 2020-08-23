<?php

namespace App\Exports;

use App\Services\TestitemService;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TestitemQueryExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @var Invoice $testitem
     */
    public function map($testitem): array
    {
        return [
            $testitem->id,
            $testitem->question,
            $testitem::TYPES[$testitem->type_id],
            $testitem->competency->title,
            $testitem->options,
            $testitem->answer,
            $testitem->timeout,
            Date::dateTimeToExcel($testitem->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Question',
            'Type',
            'Competency',
            'Options',
            'Answer',
            'Timeout',
            'Date Created'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_DATETIME
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $service = App::make(TestitemService::class);
        return $service->filteredQuery($this->data);
    }
}
