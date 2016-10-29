<?php

namespace Php\Form\Builder\Element;

class Help extends HTML
{
    const NAME = 'p';

    public function __construct($inner, array $attributes = [])
    {
        parent::__construct(self::NAME, $inner, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'help-block'
        ];
    }
}
