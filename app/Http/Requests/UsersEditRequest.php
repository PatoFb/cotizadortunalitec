<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersEditRequest extends FormRequest
{
    private $user_id; // Instance variable to store the user ID

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->check() && auth()->user()->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'partner_id' => ['required', 'exists:partners,number'],
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user_id)],
            'role_id'=> ['required', 'exists:roles,id'],
            'discount'=> ['required', 'numeric', 'min:0', 'max:100'],
            'cfdi' => ['required'],
            'phone' => ['required', 'digits:10', 'integer'],
            'rfc' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'partner_id.required' => 'El campo ID de socio es obligatorio.',
            'partner_id.exists' => 'El ID de socio seleccionado no existe en la base de datos.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'role_id.required' => 'El campo rol es obligatorio.',
            'role_id.exists' => 'El ID de rol seleccionado no existe en la base de datos.',
            'cfdi.required' => 'El campo CFDI es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.digits' => 'El teléfono debe tener :digits dígitos.',
            'phone.integer' => 'El teléfono debe ser un número entero.',
            'rfc.required' => 'El campo RFC es obligatorio.',
        ];
    }
}
