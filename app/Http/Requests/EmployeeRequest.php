<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class EmployeeRequest extends FormRequest
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
            'first_name'=>[
                'required',
                'min:3',
                'max:255',
            ],
            'last_name'=>[
                'required',
                'min:3',
                'max:255',
            ],
            'company_id'=>[
                'min:1',
                'max:255',
            ],
            'email'=>[
                'min:3',
                'max:255',
                'email',
            ],
            'phone'=>[

            ],


        ];
        if ($this->route()->named('employees.store')){
            $rules['first_name'].='unique:employees,first_name';
            $rules['last_name'].='unique:employees,last_name';
        }
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
