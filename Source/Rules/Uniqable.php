<?php

namespace Alighorbani\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class Uniqable implements Rule
{
    const FIRST_INDEX = 0;
    
    /** @var Illuminate\Database\Eloquent\Model  */
    public $model;

    /** @var int except validation param*/
    public $except;

    /** @var mixed the column validation it*/
    public $colum;

    public function __construct(string $model, $except = null, string $colum)
    {
        $this->model = $model;

        $this->except = $except;

        $this->colum = $colum;
    }

    public function isExceptableValidation()
    {
        return $this->except != null;
    }

    /**
     * Make a base Rule Structure
     * 
     * @return array
     */
    public function ruleStructure()
    {
        return ["unique:{$this->model},{$this->colum}"];
    }

    /**
     * Chose which type of uniqable validation must be used
     * 
     * @return array
     */
    public function getGeneratedRule()
    {
        if ($this->isExceptableValidation()) {
            return $this->ruleStructure()[self::FIRST_INDEX] .= "," . $this->except;            
        }

        return $this->ruleStructure();
    }

    /**
     * The Pass Function Called By Laravel Freamwork to validation data
     * 
     * @param string $attribute
     * 
     * @param mixed $value
     * 
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $validator = Validator::make([$value], [$this->getGeneratedRule()]);

        return !$validator->fails(); // whene not fail validation 
    }

    /**
     * Get a mesage from translation file in laravel.com
     * when validation is failed this method called by laravel automatically
     * 
     * @return string
     */
    public function message()
    {
        return trans('validation.uniqable');
    }
}
