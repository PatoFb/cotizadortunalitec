<?php

namespace App\Http\Requests;

use App\Models\SistemaToldo;
use App\Rules\ValidateProjection;
use Illuminate\Foundation\Http\FormRequest;

class ToldoDataRequest extends FormRequest
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
            'width' => ['required', 'min:0.5', 'max:15', 'numeric'],
            'projection' => ['required', 'numeric', 'min:1', 'max:4.85'],
            'mechanism_id' => ['required', 'integer', 'exists:mechanisms,id'],
            'quantity' => ['required', 'min:1', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'width.required' => 'El campo ancho es obligatorio.',
            'width.min' => 'El ancho debe ser mínimo :min.',
            'width.max' => 'El ancho debe ser máximo :max.',
            'width.numeric' => 'El ancho debe ser un número.',

            'projection.required' => 'El campo proyección es obligatorio.',
            'projection.numeric' => 'La proyección debe ser un número.',
            'projection.min' => 'La proyección debe ser mínimo :min.',
            'projection.MAX' => 'La proyección debe ser máximo :max.',

            'mechanism_id.required' => 'El campo mecanismo es obligatorio.',
            'mechanism_id.integer' => 'El mecanismo debe ser un número entero.',
            'mechanism_id.exists' => 'El mecanismo seleccionado no existe en la base de datos.',

            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.min' => 'La cantidad debe ser al menos :min.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
        ];
    }
}
