<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
            'cfdi' => ['required'],
            'phone' => ['required', 'digits:10', 'integer'],
            'rfc' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'cfdi.required' => 'El campo CFDI es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.digits' => 'El teléfono debe tener :digits dígitos.',
            'phone.integer' => 'El teléfono debe ser un número entero.',
            'rfc.required' => 'El campo RFC es obligatorio.',
        ];
    }
}
