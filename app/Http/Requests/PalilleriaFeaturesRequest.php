<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PalilleriaFeaturesRequest extends FormRequest
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
            'control_id' => ['required', 'exists:controls,id', 'integer'],
            'voice_id' => ['required', 'exists:voice_controls,id', 'integer'],
            'control_quantity' => ['required', 'min:0', 'integer'],
            'voice_quantity' => ['required', 'min:0', 'integer'],
            'sensor_id' => ['required', 'exists:sensors,id', 'integer'],
            'guide' => ['required', 'integer', 'min:0', 'max:1'],
            'trave' => ['required', 'integer', 'min:0', 'max:1'],
            'goal' => ['required', 'integer', 'min:0', 'max:1'],
            'semigoal' => ['required', 'integer', 'min:0', 'max:1'],
            'sensor_quantity' => ['required', 'min:0', 'integer'],
            'guide_quantity' => ['required', 'min:0', 'integer'],
            'trave_quantity' => ['required', 'min:0', 'integer'],
            'semigoal_quantity' => ['required', 'min:0', 'integer'],
            'goal_quantity' => ['required', 'min:0', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'control_id.required' => 'El control es obligatorio.',
            'control_id.exists' => 'El control seleccionado no existe en la base de datos.',
            'control_id.integer' => 'El control debe ser un número entero.',

            'voice_id.required' => 'El de control de voz es obligatorio.',
            'voice_id.exists' => 'El control de voz seleccionado no existe en la base de datos.',
            'voice_id.integer' => 'El control de voz debe ser un número entero.',

            'control_quantity.required' => 'El campo cantidad de control es obligatorio.',
            'control_quantity.min' => 'La cantidad de control debe ser al menos 0.',
            'control_quantity.integer' => 'La cantidad de control debe ser un número entero.',

            'voice_quantity.required' => 'El campo cantidad de control de voz es obligatorio.',
            'voice_quantity.min' => 'La cantidad de control de voz debe ser al menos 0.',
            'voice_quantity.integer' => 'La cantidad de control de voz debe ser un número entero.',

            'sensor_id.required' => 'El campo sensor es obligatorio.',
            'sensor_id.exists' => 'El sensor seleccionado no existe en la base de datos.',
            'sensor_id.integer' => 'El sensor debe ser un número entero.',

            'guide.required' => 'El campo guía+ es obligatorio.',
            'guide.integer' => 'El campo guía+ debe ser un número entero.',
            'guide.min' => 'El campo guía+ debe ser al menos 0.',
            'guide.max' => 'El campo guía+ debe ser máximo 1.',

            'trave.required' => 'El campo trave+ es obligatorio.',
            'trave.integer' => 'El campo trave+ debe ser un número entero.',
            'trave.min' => 'El campo trave+ debe ser al menos 0.',
            'trave.max' => 'El campo trave+ debe ser máximo 1.',

            'goal.required' => 'El campo portería+ es obligatorio.',
            'goal.integer' => 'El campo portería+ debe ser un número entero.',
            'goal.min' => 'El campo portería+ debe ser al menos 0.',
            'goal.max' => 'El campo portería+ debe ser máximo 1.',

            'semigoal.required' => 'El campo semiportería+ es obligatorio.',
            'semigoal.integer' => 'El campo semiportería+ debe ser un número entero.',
            'semigoal.min' => 'El campo semiportería+ debe ser al menos 0.',
            'semigoal.max' => 'El campo semiportería+ debe ser máximo 1.',

            'sensor_quantity.required' => 'El campo cantidad de sensor es obligatorio.',
            'sensor_quantity.min' => 'La cantidad de sensor debe ser al menos 0.',
            'sensor_quantity.integer' => 'La cantidad de sensor debe ser un número entero.',

            'guide_quantity.required' => 'El campo cantidad de guía+ es obligatorio.',
            'guide_quantity.min' => 'La cantidad de guía+ debe ser al menos 0.',
            'guide_quantity.integer' => 'La cantidad de guía+ debe ser un número entero.',

            'trave_quantity.required' => 'El campo cantidad de trave+ es obligatorio.',
            'trave_quantity.min' => 'La cantidad de trave+ debe ser al menos 0.',
            'trave_quantity.integer' => 'La cantidad de trave+ debe ser un número entero.',

            'semigoal_quantity.required' => 'El campo cantidad de semiportería+ es obligatorio.',
            'semigoal_quantity.min' => 'La cantidad de semiportería+ debe ser al menos 0.',
            'semigoal_quantity.integer' => 'La cantidad de semiportería+ debe ser un número entero.',

            'goal_quantity.required' => 'El campo cantidad de portería+ es obligatorio.',
            'goal_quantity.min' => 'La cantidad de portería+ debe ser al menos 0.',
            'goal_quantity.integer' => 'La cantidad de portería+ debe ser un número entero.',
        ];
    }
}
