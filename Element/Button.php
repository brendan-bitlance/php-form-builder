<?php

namespace Php\Form\Builder\Element;

class Button extends Control
{
    const NAME = 'button';

    public function __construct($text, array $attributes = [])
    {
        parent::__construct(self::NAME, $text, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'btn btn-default',
            'type' => 'submit'
        ];
    }

    public function get_value()
    {
        return $this->value;
    }

    public function set_submitted_value($value)
    {}

}
