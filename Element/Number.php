<?php

namespace Php\Form\Builder\Element;

class Number extends Input
{
    const TYPE = 'number';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-control',
            'value' => 0,
            'min' => 0
        ];
    }
}
