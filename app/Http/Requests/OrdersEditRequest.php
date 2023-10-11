<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdersEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->check());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project' => ['required', 'max:255', 'min:3', 'string'],
            'discount' => ['required', 'min:0', 'max:100', 'numeric'],
            'comment' => ['nullable','string'],
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
            'project.required' => 'El campo proyecto es obligatorio.',
            'project.max' => 'El campo proyecto debe tener máximo :max caracteres.',
            'project.min' => 'El campo proyecto debe tener mínimo :min caracteres.',
            'project.string' => 'El campo proyecto debe ser una cadena de texto.',
            'discount.required' => 'El campo descuento es obligatorio.',
            'discount.min' => 'El descuento debe ser al menos :min.',
            'discount.max' => 'El descuento debe ser como máximo :max.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'comment.string' => 'El comentario debe ser una cadena de texto.',
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
