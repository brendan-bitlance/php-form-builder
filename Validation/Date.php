<?php

namespace Php\Form\Builder\Validation;

class Date extends AbstractValidation
{
    public function __construct($message = 'Invalid date or format - Use: DD/MM/YYYY')
    {
        parent::__construct($message);
    }

    protected function is_value_valid($value)
    {
        if (substr_count($value, '/') == 2) {
            $input_bits = explode('/', $value);
            return checkdate($input_bits[1], $input_bits[0], $input_bits[2]);
        } elseif (substr_count($value, '-') == 2) {
            $input_bits = explode('-', $value);
            return checkdate($input_bits[1], $input_bits[2], $input_bits[0]);
        }
        return false;
    }
}
