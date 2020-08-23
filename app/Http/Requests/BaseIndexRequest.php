<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Http\FormRequest;

class BaseIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'page' => 'nullable|integer',
            'per_page' => [
                'nullable',
                'integer',
                Rule::in(Config::get('custom.pagination.per_page_list'))
            ],
            'from' => 'nullable|integer',
            'to' => 'nullable|integer',
            'id' => 'nullable|integer',
            'dir' => 'nullable|in:asc,desc',
            'export' => 'nullable|in:pdf,excel,print',
            'filter' => 'nullable|boolean',
            'batch' => 'nullable|boolean'
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function getValidationData()
    {
        return [
            'page' => $this->query('page'),
            'per_page' => $this->query('per_page'),
            'from' => $this->query('from'),
            'to' => $this->query('to'),
            'order_by' => $this->query('order_by'),
            'id' => $this->query('id'),
            'dir' => $this->query('dir'),
            'export' => $this->query('export'),
            'filter' => (bool) $this->query('filter'),
            'batch' => (bool) $this->query('batch')
        ];
    }
}
