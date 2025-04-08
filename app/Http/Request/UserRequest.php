<?php
namespace LaraSlim\Http\Request;
class UserRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de e-mail válido.',
            'email.unique' => 'O campo email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'O campo senha deve ser confirmado.',
        ];
    }
}