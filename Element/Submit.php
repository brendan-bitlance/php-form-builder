<?php

namespace Php\Form\Builder\Element;

class Submit extends Input
{
    const TYPE = 'submit';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'btn btn-primary',
            'value' => 'Submit'
        ];
    }
}
