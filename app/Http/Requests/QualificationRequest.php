<?php

namespace App\Http\Requests;

use App\Qualification;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class QualificationRequest extends FormRequest
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
            'title' => 'required|string|max:150|unique:qualifications,title',
            'level_id' => [
                'required',
                Rule::in(array_keys(Qualification::LEVELS))
            ],
            'category_id' => [
                'required',
                Rule::in(array_keys(Qualification::CATEGORIES))
            ],
            'competencies' => 'nullable|array|min:1',
            'competencies.*.level' => 'required|numeric|max:4',
            'competencies.*.title' => 'required|string|max:150'
        ];
    }
}
