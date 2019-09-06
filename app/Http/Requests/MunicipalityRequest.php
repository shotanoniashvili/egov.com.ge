<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityRequest extends FormRequest
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
                    'name' => 'required|unique:municipalities|min:3',
                    'website' => 'required',
                ];

            case 'PUT':
            case 'PATCH':
                $municipality_id = $this->route('municipality');
                return [
                    'name' => 'required|min:3|unique:project_categories,name,' . $municipality_id,
                    'website' => 'required'
                ];

            default:
                break;
        }
    }
}
