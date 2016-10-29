<?php

namespace Php\Form\Builder\Validation;

use Php\Form\Builder\Element\Control;

class Required extends AbstractValidation
{
    public function __construct($message = 'Required')
    {
        parent::__construct($message);
    }

    public function process_control(Control $control)
    {
        $control->add_attribute('required', 'required');
    }

    protected function is_value_valid($value)
    {
        return strlen(trim($value)) > 0;
    }
}
