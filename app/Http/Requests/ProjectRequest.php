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
            'author.firstname' => 'nullable',
            'author.lastname' => 'nullable',
            'author.email' => 'nullable|email',
            'author.mobiles' => 'nullable|array',
            'author.about' => 'nullable',
            'short_description' => 'nullable',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'detailed_description' => 'nullable',
            'goal' => 'nullable',
            'experience' => 'nullable',
            'council_contribution' => 'nullable',
            'future_plans' => 'nullable',
            'contact_info.firstname' => 'nullable',
            'contact_info.lastname' => 'nullable',
            'contact_info.email' => 'nullable|email',
            'contact_info.mobiles' => 'nullable|array',
            'contact_info.about' => 'nullable',
        ];
    }
}
