<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFilterRequest extends FormRequest
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
            'filter.status' => 'nullable|string|exists:task_statuses,name',
            'filter.executor_id' => 'nullable|integer|exists:users,id',
            'filter.only_my' => 'nullable|boolean',
            'filter.tag_list' => 'array',
            'filter.tag_list.*' => 'integer|exists:tags,id',
        ];
    }
}
