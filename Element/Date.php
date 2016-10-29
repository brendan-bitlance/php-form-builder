<?php

namespace Php\Form\Builder\Element;

class Date extends Input
{
    const TYPE = 'date';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-control date'
        ];
    }
}
