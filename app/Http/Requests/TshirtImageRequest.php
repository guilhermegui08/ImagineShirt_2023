<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TshirtImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'file_photo' => 'required|image|max:4096',
            'category' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A imagem precisa de um nome',
            'description.required' => 'A imagem precisa de uma descrição',
            'file_photo.required' => 'Necessita de submeter uma imagem',
            'file_photo.image' => 'O ficheiro submetido não é uma imagem',
            'file_photo.size' => 'O ficheiro sibmetido excede o limite máximo de 4Mb'
        ];
    }
}
