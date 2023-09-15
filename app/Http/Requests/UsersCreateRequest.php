<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersCreateRequest extends FormRequest
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
            'partner_id' => ['required', 'exists:partners,number'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id'=> ['required', 'exists:roles,id'],
            'discount'=> ['required', 'numeric', 'min:0', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cfdi' => ['required'],
            'rfc' => ['required'],
            'phone' => ['required', 'digits:10', 'integer'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required', 'integer', 'digits:5'],
            'line1' => ['required'],
            'line2' => ['required'],
            'reference' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'partner_id.required' => 'El campo número es obligatorio.',
            'partner_id.exists' => 'El número de socio no existe en la base de datos.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los :max caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico no debe exceder los :max caracteres.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'role_id.required' => 'El campo rol es obligatorio.',
            'role_id.exists' => 'El rol seleccionado no existe en la base de datos.',
            'discount.required' => 'El campo descuento es obligatorio.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'discount.min' => 'El descuento debe ser al menos :min.',
            'discount.max' => 'El descuento debe ser como máximo :max.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'cfdi.required' => 'El campo CFDI es obligatorio.',
            'rfc.required' => 'El campo RFC es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.digits' => 'El teléfono debe tener :digits dígitos.',
            'phone.integer' => 'El teléfono debe ser un número entero.',
            'city.required' => 'El campo ciudad es obligatorio.',
            'state.required' => 'El campo estado es obligatorio.',
            'zip_code.required' => 'El campo código postal es obligatorio.',
            'zip_code.integer' => 'El código postal debe ser un número entero.',
            'zip_code.digits' => 'El código postal debe tener :digits dígitos.',
            'line1.required' => 'El campo dirección (línea 1) es obligatorio.',
            'line2.required' => 'El campo dirección (línea 2) es obligatorio.',
            'reference.string' => 'La referencia debe ser una cadena de texto.',
        ];
    }
}
