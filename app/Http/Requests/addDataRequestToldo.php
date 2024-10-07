<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addDataRequestToldo extends FormRequest
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
            'cover_id' => ['required', 'exists:covers,id', 'integer'],
            'width' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'projection' => ['required', 'numeric'],
            'handle_id' => ['required', 'exists:handles,id', 'integer'],
            'canopy' => ['required', 'integer', 'min:0', 'max:1'],
            'bambalina' => ['required', 'integer', 'min:0', 'max:1'],
            'control_id' => ['required', 'exists:controls,id', 'integer'],
            'voice_id' => ['required', 'exists:voice_controls,id', 'integer'],
            'sensor_id' => ['required', 'exists:sensors,id', 'integer'],
            'control_quantity' => ['required', 'min:0', 'integer'],
            'handle_quantity' => ['required', 'min:0', 'integer'],
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

            'projection.required' => 'El campo proyección es obligatorio.',
            'projection.numeric' => 'La proyección debe ser un número.',

            'handle_id.required' => 'El campo manivela es obligatorio.',
            'handle_id.exists' => 'La manivela seleccionado no existe en la base de datos.',
            'handle_id.integer' => 'La manivela debe ser un número entero.',

            'canopy.required' => 'El campo tejadillo es obligatorio.',
            'canopy.integer' => 'El campo tejadillo debe ser un número entero.',
            'canopy.min' => 'El campo tejadillo debe ser al menos 0.',
            'canopy.max' => 'El campo tejadillo debe ser máximo 1.',

            'bambalina.required' => 'El campo bambalina es obligatorio.',
            'bambalina.integer' => 'El campo bambalina debe ser un número entero.',
            'bambalina.min' => 'El campo bambalina debe ser al menos 0.',
            'bambalina.max' => 'El campo bambalina debe ser máximo 1.',

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

            'handle_quantity.required' => 'El campo cantidad de manivela es obligatorio.',
            'handle_quantity.min' => 'La cantidad de manivela debe ser al menos 0.',
            'handle_quantity.integer' => 'La cantidad de manivela debe ser un número entero.',

            'voice_quantity.required' => 'El campo cantidad de control de voz es obligatorio.',
            'voice_quantity.min' => 'La cantidad de control de voz debe ser al menos 0.',
            'voice_quantity.integer' => 'La cantidad de control de voz debe ser un número entero.',

            'quantity.required' => 'El campo cantidad es obligatorio.',
            'quantity.min' => 'La cantidad debe ser al menos :min.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
        ];
    }
}
