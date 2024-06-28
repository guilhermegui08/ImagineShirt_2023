<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('users', 'name')->ignore($this->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'user_type' => 'required|in:A,E',
            'blocked' => 'sometimes|in:0,1',
            'file_foto' => 'sometimes|image|max:4096', // maxsize = 4Mb
            'password_inicial' => 'sometimes|required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.unique' => 'O nome tem que ser único',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O formato do email é inválido',
            'email.unique' => 'O email tem que ser único',
            'file_foto.image' => 'O ficheiro com a foto não é uma imagem',
            'file_foto.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb',
            'password_inicial.required' => 'A password inicial é obrigatória'
        ];
    }
}
