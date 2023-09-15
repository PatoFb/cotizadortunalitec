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
            'activity' => 'required',
            'project' => ['required', 'max:255', 'min:3', 'string'],
            'discount' => ['required', 'min:0', 'max:100', 'numeric'],
            'comment' => ['nullable','string']
        ];
    }

    public function messages()
    {
        return [
            'activity.required' => 'El campo actividad es obligatorio.',
            'project.required' => 'El campo proyecto es obligatorio.',
            'project.max' => 'El campo proyecto debe tener máximo :max caracteres.',
            'project.min' => 'El campo proyecto debe tener mínimo :min caracteres.',
            'project.string' => 'El campo proyecto debe ser una cadena de texto.',
            'discount.required' => 'El campo descuento es obligatorio.',
            'discount.min' => 'El descuento debe ser al menos :min.',
            'discount.max' => 'El descuento debe ser como máximo :max.',
            'discount.numeric' => 'El descuento debe ser un número.',
            'comment.string' => 'El comentario debe ser una cadena de texto.',
        ];
    }
}
