<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompetencyExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'level_id' => 'nullable|integer',
            'order_by' => 'nullable|alpha_dash',
            'dir' => 'nullable|in:asc,desc'
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return [
            'search' => $this->query('search'),
            'category_id' => $this->query('category_id'),
            'level_id' => $this->query('level_id'),
            'order_by' => $this->query('order_by'),
            'dir' => $this->query('dir')
        ];
    }
}
