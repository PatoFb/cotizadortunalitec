<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addDataRequestPalilleria extends FormRequest
{
    public function rules()
    {
        return [
            'cover_id' => ['required', 'exists:covers,id', 'integer'],
            'width' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'height' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'control_id' => ['required', 'exists:controls,id', 'integer'],
            'voice_id' => ['required', 'exists:voice_controls,id', 'integer'],
            'sensor_id' => ['required', 'exists:sensors,id', 'integer'],
            'control_quantity' => ['required', 'min:0', 'integer'],
            'voice_quantity' => ['required', 'min:0', 'integer'],
            'sensor_quantity' => ['required', 'min:0', 'integer'],
            'quantity' => ['required', 'min:1', 'integer'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cover_id.required' => 'Por favor selecciona una cubierta',
            'cover_id.exists' => 'Por favor selecciona una cubierta válida',
            'cover_id.integer' => 'Por favor selecciona una cubierta válida',

            'width.required' => 'El campo ancho es obligatorio.',
            'width.min' => 'El ancho debe ser mínimo :min.',
            'width.max' => 'El ancho debe ser máximo :max.',
            'width.numeric' => 'El ancho debe ser un número.',

            'height.required' => 'El campo caída es obligatorio.',
            'height.min' => 'La caída debe ser mínima :min.',
            'height.max' => 'La caída debe ser máxima :max.',
            'height.numeric' => 'La caída debe ser un número.',

            'control_id.required' => 'El campo control es obligatorio.',
            'control_id.exists' => 'El control seleccionado no existe en la base de datos.',
            'control_id.integer' => 'El control debe ser un número entero.',

            'voice_id.required' => 'El campo control de voz es obligatorio.',
            'voice_id.exists' => 'El control de voz seleccionado no existe en la base de datos.',
            'voice_id.integer' => 'El control de voz debe ser un número entero.',

            'control_quantity.required' => 'El campo cantidad de control es obligatorio.',
            'control_quantity.min' => 'La cantidad de control debe ser al menos 0.',
            'control_quantity.integer' => 'La cantidad de control debe ser un número entero.',

            'sensor_id.required' => 'El campo sensor es obligatorio.',
            'sensor_id.exists' => 'El sensor seleccionado no existe en la base de datos.',
            'sensor_id.integer' => 'El sensor debe ser un número entero.',

            'sensor_quantity.required' => 'El campo cantidad de sensor es obligatorio.',
            'sensor_quantity.min' => 'La cantidad de sensor debe ser al menos 0.',
            'sensor_quantity.integer' => 'La cantidad de sensor debe ser un número entero.',

            'voice_quantity.required' => 'El campo cantidad de control de voz es obligatorio.',
            'voice_quantity.min' => 'La cantidad de control de voz debe ser al menos 0.',
            'voice_quantity.integer' => 'La cantidad de control de voz debe ser un número entero.',

            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.min' => 'La cantidad debe ser al menos :min.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
        ];
    }
}
