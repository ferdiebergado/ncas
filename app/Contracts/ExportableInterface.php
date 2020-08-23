<?php

namespace App\Contracts;

interface ExportableInterface
{
    /**
     * Export data from a view.
     *
     * @param string $view
     * @param mixed $data
     * @return void
     */
    public function export(string $view, $data);
}
