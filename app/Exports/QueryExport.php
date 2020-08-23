<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;

class QueryExport implements FromQuery
{
    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        //
    }
}
