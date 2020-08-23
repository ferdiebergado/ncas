<?php

namespace App\Http\Requests;

class CompetencyIndexRequest extends BaseIndexRequest
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
            'competency_id' => 'nullable|string',
            'title' => 'nullable|string|max:50',
            'level' => 'nullable|integer|max:4',
            'qualification_id' => 'nullable|string',
            'order_by' => 'nullable|in:id,title,competency_id,level, qualification_id',
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
            'competency_id' => $this->query('competency_id'),
            'level' => $this->query('level'),
            'title' => $this->query('title'),
            'qualification_id' => $this->query('qualification_id'),
            'order_by' => $this->query('order_by')
        ]);
    }
}
