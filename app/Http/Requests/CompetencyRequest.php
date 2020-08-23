<?php

namespace App\Http\Requests;

use App\Competency;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompetencyRequest extends FormRequest
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
            'level' => 'required|numeric|max:4',
            'title' => 'required|string|max:100',
            'qualification_id' => 'required|exists:qualifications,qualification_id'
        ];
    }
}
