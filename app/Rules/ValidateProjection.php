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
        $newWidth = ceilMeasure($toldo['width'], 1.5);
        return SistemaToldo::where('modelo_toldo_id', $toldo['model_id'])->
                             where('mechanism_id', $toldo['mechanism_id'])->
                             where('projection', $value)->
                             where('width', $newWidth)->exists();
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
