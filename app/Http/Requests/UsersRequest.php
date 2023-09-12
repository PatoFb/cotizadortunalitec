<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required', 'min:3'
            ],
            'email' => [
                'required', 'email'
            ],
            'password' => [
                'required', 'min:6'
            ],
            'confirm_password' => [
                'required', 'min:6', 'same:password'
            ],
            'role_id'=>'required',
            'partner_id'=>['required', 'numeric', 'exists:App\Models\Partner,number']
        ];
    }
}
