<?php

namespace Php\Form\Builder\Validation;

class Email extends AbstractValidation
{
    public function __construct($message = 'Invalid email address')
    {
        parent::__construct($message);
    }

    protected function is_value_valid($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
