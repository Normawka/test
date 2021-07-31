<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $rules= [
            'name'=>[
                'required',
                'min:3',
                'max:255',
                'unique'
            ],
            'email'=>[
                'min:3',
                'max:255',
                'email',
            ],
            'phone'=>[

            ],
            'website'=>[
                'min:3',
                'max:255',
            ],
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для ввода' ,
            'min' => 'Поле :attribute  должно иметь минимум :min символов',
            'max' => 'Поле :attribute должно иметь максимум :max символов',
            'numeric' => 'Поле :attribute должно содержать только числа',
            'unique' => 'Такой :attribute сушествует введите другие данные'

        ];
    }
}
