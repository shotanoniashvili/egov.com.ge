<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
                    'question' => 'required|unique:faqs,question|min:3',
                    'answer' => 'required',
                    'tag' => 'nullable',
                ];

            case 'PUT':
            case 'PATCH':
                $faq_id = $this->route('faq');
                return [
                    'question' => 'required|min:3|unique:faqs,question,' . $faq_id,
                    'answer' => 'required',
                    'tag' => 'nullable',
                ];

            default:
                break;
        }
    }
}
