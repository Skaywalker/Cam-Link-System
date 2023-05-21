<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
           if (Auth::user()->tokenCan('installer')){
               return true;
           }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' =>'required|unique:customers',
            'email' =>'required|unique:customers|email',
            'tel' =>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' =>'A név kitőltése kötlező!',
            'email.required' =>'A email kitőltése kötlező!',
            'tel.required' =>'A telefonszám kitőltése kötlező!',
            'name.unique' =>'A név már létezik!',
            'email.unique' =>'A email már létezik!',
        ];
    }
}
