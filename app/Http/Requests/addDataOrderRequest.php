<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addDataOrderRequest extends FormRequest
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
            'cover_id' => ['required', 'exists:covers,id', 'integer', 'min:20'],
            'mechanism_side' => 'required',
            'installation_type' => 'required',
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
            'cover_id.min' => 'Por favor selecciona una cubierta válida',

            'mechanism_side.required' => 'Por favor selecciona el lado del mecanismo',
            'installation_type.required' => 'Por favor selecciona el tipo de instalación',
        ];
    }
}
