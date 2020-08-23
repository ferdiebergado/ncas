<?php

namespace App\Contracts;

interface BatchExportableInterface
{
    /**
     * Export data in batches
     *
     * @param string $exportClass
     * @param array $data
     * @return void
     */
    public function export(string $exportClass, array $data);
}
