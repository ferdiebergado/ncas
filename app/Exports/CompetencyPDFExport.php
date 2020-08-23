<?php

namespace App\Exports;

use App\Services\CompetencyService;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\CompetencyCachedRepository;

class CompetencyPDFExport implements FromQuery
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $orderBy = $this->data['order_by'];
        $dir = $this->data['dir'];

        $repo = App::make(CompetencyCachedRepository::class);
        $service = App::make(CompetencyService::class);
        $filtered = $service->getFilterFields($this->data);
        $repo->filter($filtered, $orderBy, $dir);
        return $repo->get();
    }
}
