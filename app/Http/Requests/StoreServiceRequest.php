<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category' => 'required|integer',
            'name' => 'required|string|max:255',
            'price_per_k' => 'required|numeric|gt:0',
//            'min' => 'required|integer|gt:0|lt:'. $request->max,
//            'max' => 'required|integer|gt:'. $request->min,
            'details' => 'required|string',
            'api_service_id' => ['nullable', 'integer', 'gt:0',
                Rule::unique('services', 'api_service_id')
                    ->where('api_provider_id', $this->input('api_provider_id'))
            ]
        ];
    }

    public function messages()
    {
        return [
            'unique' => 'الباقة موجودة مسبقاً',
        ];
    }
}
