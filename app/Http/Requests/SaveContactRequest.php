<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveContactRequest extends FormRequest
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
            'name' => [
                'required', 
                'string',
                'min:5', 
                'max:255'
            ],
            'email' => [
                'required', 
                'email',
                'min:5', 
                'max:255',
                Rule::unique('contacts', 'email')->ignore($this->input('id'))
            ],
            'contact' => [
                'required', 
                'string',
                'size:9',
                Rule::unique('contacts', 'contact')->ignore($this->input('id'))
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O campo de nome é obrigatório',
            'name.string' => 'O campo de nome deve ser uma string',
            'name.min' => 'O campo de nome deve conter no mínimo 5 caracteres',
            'name.max' => 'O campo de nome deve conter no máximo 255 caracteres',
            'email.required' => 'O campo de email é obrigatório',
            'email.email' => 'O campo de email deve ser um endereço de email válido',
            'email.unique' => 'O email já está em uso',
            'email.min' => 'O campo de email deve conter no mínimo 5 caracteres',
            'email.max' => 'O campo de email deve conter no máximo 255 caracteres',
            'contact.required' => 'O campo de contato é obrigatório',
            'contact.unique' => 'O contato já está em uso',
            'contact.size' => 'O campo de contato deve conter exatamente 9 caracteres',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'contact' => preg_replace('/\D/', '', $this->contact),
        ]);
    }
}
