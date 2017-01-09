<?php

namespace Php\Form\Builder\Element;

class DateTime extends Input
{
    const TYPE = 'datetime';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-control ' . self::TYPE
        ];
    }
}
