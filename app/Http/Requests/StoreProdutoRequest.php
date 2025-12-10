<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => 'required|string|max:150',
            'preco' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um número.',
            'preco.min' => 'O preço deve ser mínimo 0.',
        ];
    }
}
