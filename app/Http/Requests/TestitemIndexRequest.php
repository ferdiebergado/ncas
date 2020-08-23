<?php

namespace App\Http\Requests;

class TestitemIndexRequest extends BaseIndexRequest
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
        return array_merge($this->getRules(), [
            'type' => 'nullable|string|max:2',
            'competency_id' => 'nullable|integer',
            'question' => 'nullable|string|max:250',
            'options' => 'nullable|string|max:150',
            'answer' => 'nullable|string|max:50',
            'timeout' => 'nullable|integer',
            'order_by' => 'nullable|in:id,type,category_uuid,question,answer,timeout',
        ]);
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->getValidationData(), [
            'type' => $this->query('type'),
            'competency_id' => $this->query('competency_id'),
            'question' => $this->query('question'),
            'options' => $this->query('options'),
            'answer' => $this->query('answer'),
            'timeout' => $this->query('timeout'),
        ]);
    }
}
