<?php

namespace App\Exports;

use App\Services\CompetencyService;
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

class CompetencyQueryExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @var Invoice $invoice
     */
    public function map($competency): array
    {
        return [
            $competency->id,
            $competency->title,
            $competency::LEVELS[$competency->level_id],
            $competency::CATEGORIES[$competency->category_id],
            Date::dateTimeToExcel($competency->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Level',
            'Category',
            'Created At'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DATETIME
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }


    /**
     * @return Builder
     */
    public function query()
    {
        $service = App::make(CompetencyService::class);
        return $service->filteredQuery($this->data);
    }
}
