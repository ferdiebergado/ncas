<?php

namespace App\Http\Requests;

use App\TestItem;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TestItemRequest extends FormRequest
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
            'competency_uuid' => 'required|UUID',
            'type' => [
                'required',
                Rule::in(array_keys(TestItem::TYPES))
            ],
            'question' => 'required|max:250',
            'options' => [
                'exclude_unless:type,M',
                'array',
                'required',
                function ($attr, $opts, $fail) {
                    foreach ($opts as $opt) {
                        $max = 150;
                        if (Str::length($opt) > $max) {
                            $fail($attr . "must not exceed " . $max . " characters.");
                        }
                    }
                }
            ],
            'timeout' => 'required|integer|min:5|max:600'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($v)
    {
        $rules = [
            [
                'type' => 'M',
                'rule' => 'required|in_array:options.*'
            ],
            [
                'type' => 'T',
                'rule' => 'required|in:T,F'
            ],
            [
                'type' => 'I',
                'rule' => 'required|max:150'
            ],
            [
                'type' => null,
                'rule' => 'required'
            ],
        ];

        foreach ($rules as $rule) {
            $v->sometimes('answer', $rule['rule'], function ($input) use ($rule) {
                return $input->type === $rule['type'];
            });
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'competency_uuid.required' => 'The competency field is required.'
        ];
    }
}
