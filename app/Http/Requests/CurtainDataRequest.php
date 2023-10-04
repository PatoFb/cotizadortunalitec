<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurtainDataRequest extends FormRequest
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
            'width' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'height' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'mechanism_id' => ['required', 'integer', 'exists:mechanisms,id'],
            'quantity' => ['required', 'min:1', 'integer'],
            'squared' => 'max:25'
        ];
    }

    public function messages()
    {
        return [
            'width.required' => 'El campo ancho es obligatorio.',
            'width.min' => 'El ancho debe ser mínimo :min.',
            'width.max' => 'El ancho debe ser máximo :max.',
            'width.numeric' => 'El ancho debe ser un número.',

            'height.required' => 'El campo caída es obligatorio.',
            'height.min' => 'La caída debe ser mínima :min.',
            'height.max' => 'La caída debe ser máxima :max.',
            'height.numeric' => 'La caída debe ser un número.',

            'mechanism_id.required' => 'El campo mecanismo es obligatorio.',
            'mechanism_id.integer' => 'El mecanismo debe ser un número entero.',
            'mechanism_id.exists' => 'El mecanismo seleccionado no existe en la base de datos.',

            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.min' => 'La cantidad debe ser al menos :min.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',

            'squared.max' => 'El total de metros cuadrados del sistema no pueden exceder de :max.',
        ];
    }
}
