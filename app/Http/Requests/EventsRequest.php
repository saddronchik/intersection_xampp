<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_citizen' => 'required',
            'who_noticed' => 'required',
            'where_noticed' => 'required',
            'detection_date' => 'required',
            'user' => 'required',
        ];
    }
    public function messages()
    {
        return[
            'id_citizen.required' => 'Выберите гражданина!',
            'who_noticed.required' => 'Заполните поле "Кто заметил"!',
            'where_noticed.required' => 'Заполните поле "Где заметил"!',
            'detection_date.required' => 'Выберите дату обнаружения !',
            'user.required' => 'Выберите пользователя!',
        ];
    }
}
