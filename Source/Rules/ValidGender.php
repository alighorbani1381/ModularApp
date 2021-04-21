<?php

namespace Modules\Source\Rules;


use Illuminate\Contracts\Validation\Rule;
use Modules\Operator\Services\GenderAlias;

class ValidGender implements Rule
{

    public function passes($attribute, $value)
    {
        return GenderAlias::isValidAlias($value);
    }

    public function message()
    {
        return trans('validation.gender');
    }
}
