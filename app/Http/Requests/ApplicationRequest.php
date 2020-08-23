<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'last_name' => 'required|string|max:60',
            'first_name' => 'required|string|max:60',
            'middle_name' => 'nullable|string|max:60',
            'sex' => 'required|in:M,F',
            'mobile' => 'required|regex:/^(9){1}[0-9]{9}$/',
            'email' => 'required|email',
            'qualification_id' => 'required|exists:qualifications,qualification_id',
            'competencies' => 'nullable|array|min:1',
            'competencies.*' => 'required|exists:competencies,competency_id'
        ];
    }
}
