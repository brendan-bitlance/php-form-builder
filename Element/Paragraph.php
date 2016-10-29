<?php

namespace Php\Form\Builder\Element;

class Paragraph extends Control
{
    const NAME = 'p';

    public function __construct($inner = parent::INNER_BLANK, array $attributes = [])
    {
        parent::__construct(self::NAME, $inner, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-control-static'
        ];
    }

    public function get_value()
    {
        return $this->inner;
    }

    public function set_submitted_value($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $this->inner = implode(', ', $value);
    }
}
