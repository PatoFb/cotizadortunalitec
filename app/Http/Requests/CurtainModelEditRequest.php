<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurtainModelEditRequest extends FormRequest
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
            'description'=>'required',
            'type_id'=>'required',
            'max_resistance'=>'required',
            'production_time'=>'required',
            'max_width'=>'required',
            'max_height'=>'required',
            'base_price'=>'required',
            'photo'=>'required|max:10000|mimes:jpg,png,jpeg'
        ];
    }
}
