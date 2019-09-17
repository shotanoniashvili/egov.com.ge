<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|min:3,unique:projects,title',
            'category_id' => 'nullable|exists:project_categories,id',
            'short_description' => 'nullable',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'picture' => 'nullable|mimes:png,jpg,gif,bmp,jpeg',
            'documents' => 'nullable|array',
            // TODO 'documents.*' => 'nullable|max:20MB|mimes:docx,doc,xlsx,xls,pdf,csv',
            'project_date' => 'nullable|date_format:"Y-m-d"'
        ];
    }
}
