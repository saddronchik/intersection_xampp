<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitisenCreateRequest extends FormRequest
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
        return [
            'full_name' => 'required',
            'passport_data' => 'required',
            'date_birth' => 'required',
            'user' => 'required',
        ];
    }
    public function messages()
    {
        return[
            'full_name.required' => 'Заполните поле ФИО!',
            'date_birth.required' => 'Укажите дату рождения!',
            'passport_data.required' => 'Заполните поле паспорта!',
            'user.required' => 'Выберите пользователя!',
        ];
    }

}
