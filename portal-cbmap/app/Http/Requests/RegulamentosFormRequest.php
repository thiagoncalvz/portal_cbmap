<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegulamentosFormRequest extends FormRequest
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
            'titulo' => ['required', 'min:2'],
            // 'documento' => ['required']
        ];
    }

    public function messages(){
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            // 'documento.required' => 'É obrigatório adicionar um documento (PDF).',
            'titulo.min' => 'O campo título precisa de pelo menos :min caracteres.'
        ];
    }
}
