<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoverOrderRequest extends FormRequest
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
            'cover_id' => ['required', 'exists:covers,id', 'integer', 'min:20']
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
        ];
    }
}
