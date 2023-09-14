<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoverEditRequest extends FormRequest
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
            'name'=>'required',
            'roll_width'=>'required',
            'unions'=>'required',
            'price'=>'required',
            'photo'=>'required|max:10000|mimes:jpg,png,jpeg'
        ];
    }
}
