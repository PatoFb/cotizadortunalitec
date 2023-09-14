<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
