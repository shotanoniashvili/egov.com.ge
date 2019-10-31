<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
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
                    'name' => 'required|unique:rates',
                    'project_category_id' => 'required|exists:project_categories,id|unique:rates,project_category_id',
                    'criterias' => 'array',
                    'criterias.*.name' => 'required',
                    'criterias.*.percent_in_total' => 'required|int',
                    'criterias.*.subcriterias' => 'array',
                    'criterias.*.subcriterias.*.name' => 'required|string',
                    'criterias.*.subcriterias.*.number_field' => 'required|number',
                    'criterias.*.subcriterias.*.max_point' => 'nullable|int',
                    'criterias.*.subcriterias.*.yes_point' => 'nullable|int',
                    'criterias.*.subcriterias.*.no_point' => 'nullable|int',
                ];

            case 'PUT':
            case 'PATCH':
                $rate = $this->route('rate');
            return [
                'name' => 'required|unique:rates,'.$rate->id,
                'project_category_id' => 'required|exists:project_categories,id|unique:rates,project_category_id,'.$rate->id,
                'criterias' => 'array',
                'criterias.*.name' => 'required',
                'criterias.*.percent_in_total' => 'required|int',
                'criterias.*.subcriterias' => 'array',
                'criterias.*.subcriterias.*.name' => 'required|string',
                'criterias.*.subcriterias.*.number_field' => 'required|number',
                'criterias.*.subcriterias.*.max_point' => 'nullable|int',
                'criterias.*.subcriterias.*.yes_point' => 'nullable|int',
                'criterias.*.subcriterias.*.no_point' => 'nullable|int',
            ];

            default:
                break;
        }
    }
}
