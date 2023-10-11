<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurtainFeaturesOrderRequest extends FormRequest
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
            'handle_id' => ['required', 'exists:handles,id', 'integer'],
            'canopy' => ['required', 'integer', 'min:0', 'max:1'],
            'control_id' => ['required', 'exists:controls,id', 'integer'],
            'voice_id' => ['required', 'exists:voice_controls,id', 'integer'],
            'control_quantity' => ['required', 'min:0', 'integer'],
            'handle_quantity' => ['required', 'min:0', 'integer'],
            'voice_quantity' => ['required', 'min:0', 'integer'],
            'mechanism_side' => 'required',
            'installation_type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'handle_id.required' => 'El campo manivela es obligatorio.',
            'handle_id.exists' => 'La manivela seleccionado no existe en la base de datos.',
            'handle_id.integer' => 'La manivela debe ser un número entero.',

            'canopy.required' => 'El campo tejadillo es obligatorio.',
            'canopy.integer' => 'El campo tejadillo debe ser un número entero.',
            'canopy.min' => 'El campo tejadillo debe ser al menos 0.',
            'canopy.max' => 'El campo tejadillo debe ser máximo 1.',

            'control_id.required' => 'El campo control es obligatorio.',
            'control_id.exists' => 'El control seleccionado no existe en la base de datos.',
            'control_id.integer' => 'El control debe ser un número entero.',

            'voice_id.required' => 'El campo control de voz es obligatorio.',
            'voice_id.exists' => 'El control de voz seleccionado no existe en la base de datos.',
            'voice_id.integer' => 'El control de voz debe ser un número entero.',

            'control_quantity.required' => 'El campo cantidad de control es obligatorio.',
            'control_quantity.min' => 'La cantidad de control debe ser al menos 0.',
            'control_quantity.integer' => 'La cantidad de control debe ser un número entero.',

            'handle_quantity.required' => 'El campo cantidad de manivela es obligatorio.',
            'handle_quantity.min' => 'La cantidad de manivela debe ser al menos 0.',
            'handle_quantity.integer' => 'La cantidad de manivela debe ser un número entero.',

            'voice_quantity.required' => 'El campo cantidad de control de voz es obligatorio.',
            'voice_quantity.min' => 'La cantidad de control de voz debe ser al menos 0.',
            'voice_quantity.integer' => 'La cantidad de control de voz debe ser un número entero.',

            'mechanism_side.required' => 'Por favor selecciona el lado del mecanismo',
            'installation_type.required' => 'Por favor selecciona el tipo de instalación',
        ];
    }
}
