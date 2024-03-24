<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'operator_id' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome do produto',
            'price' => 'Informe o valor do produto',
            'operator_id' => 'Selecione a operadora',
            'category_id' => 'Selecione a categoria'
        ];
    }
}
