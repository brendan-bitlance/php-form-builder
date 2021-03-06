<?php

namespace Php\Form\Builder\Element;

class Textarea extends Control
{
    const NAME = 'textarea';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-control',
            'rows' => 3,
            'cols' => 30
        ];
    }

    public function get_value()
    {
        return $this->inner;
    }

    public function set_submitted_value($value)
    {
        if (is_scalar($value)) {
            $this->inner = $value;
        }
    }
}
