<?php

namespace App\Rules;

use App\Models\SistemaToldo;
use Illuminate\Contracts\Validation\Rule;

class ValidateProjection implements Rule
{

    private $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $toldo = $this->data['toldo'];
        return SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La proyección seleccionada no es válida.';
    }
}
