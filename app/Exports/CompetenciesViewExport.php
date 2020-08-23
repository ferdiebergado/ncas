<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class CompetenciesViewExport implements FromView
{
    protected $data;
    protected $competencyService;

    public function __construct(Collection $data)
    {
        $this->data = $data;
        $this->competencyService = app(\App\Services\CompetencyService::class);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $data = $this->competencyService->search($this->data, false, true);

        return view('competency.export', compact('data'));
    }
}
