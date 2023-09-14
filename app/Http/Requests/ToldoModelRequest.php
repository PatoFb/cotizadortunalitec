<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToldoModelRequest extends FormRequest
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
            'model_id' => ['required', 'exists:modelo_toldos,id', 'integer']
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
            'model_id.required' => 'Por favor selecciona un modelo.',
            'model_id.exists' => 'Por favor selecciona un modelo válido',
            'model_id.integer' => 'Por favor selecciona un modelo válido',
        ];
    }
}
