<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addDataRequest extends FormRequest
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
            'mechanism_side' => 'nullable',
            'installation_type' => 'nullable',
            'width' => ['required', 'min:0.5', 'max:10', 'numeric'],
            'height' => ['required', 'min:0.5', 'max:10', 'numeric'],
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
        ];
    }
}
