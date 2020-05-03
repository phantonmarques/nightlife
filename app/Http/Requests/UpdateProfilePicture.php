<?php

namespace App\Http\Requests;

class UpdateProfilePicture extends FormRequest
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
        $rules = [
            'profile_picture_path' => ['required' , 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'profile_picture_path.required' => 'Favor, insira imagem para capa do evento!',
            'profile_picture_path.image' => 'Imagem inválida, favor insira uma imagem no formato correto!',
            'profile_picture_path.mimes' => 'Imagem inválida, favor insira uma imagem no formato correto (jpeg, jpg, png, gif e svg)!',
            'profile_picture_path.max' => 'Imagem inválida, favor insira uma imagem no formato correto!',
        ];
    }
}
