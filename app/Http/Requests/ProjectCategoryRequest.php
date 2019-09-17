<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectCategoryRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];

            case 'POST':
                return [
                    'name' => 'required|unique:project_categories|min:3',
                ];

            case 'PUT':
            case 'PATCH':
                $project_category_id = $this->route('project_category');
                return [
                    'name' => 'required|min:3|unique:project_categories,name,' . $project_category_id
                ];

            default:
                break;
        }
    }
}
