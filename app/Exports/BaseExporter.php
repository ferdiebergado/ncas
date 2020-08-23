<?php

namespace App\Exports;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class BaseExporter
{
    protected $basename;

    public function __construct()
    {
        $this->generateBaseName();
    }

    protected function generateBaseName()
    {
        $tz = Config::get('custom.misc.tz', 'Asia/Manila');
        $fileid = now($tz)->format('m-d-Y_h-m-s-a') . '-' . Str::random(8);
        $this->basename = config('app.name') . '-export-' . $fileid;
    }
}
