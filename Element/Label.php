<?php

namespace Php\Form\Builder\Element;

class Label extends HTML
{
    const NAME = 'label';

    public function __construct($inner, array $attributes = [])
    {
        parent::__construct(self::NAME, $inner, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'control-label'
        ];
    }
}
