<?php

namespace Php\Form\Builder\Validation;

class Custom extends AbstractValidation
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(callable $callback, $message = null)
    {
        parent::__construct($message);
        $this->callback = $callback;
    }

    protected function is_value_valid($value)
    {
        return call_user_func($this->callback, $value);
    }
}
