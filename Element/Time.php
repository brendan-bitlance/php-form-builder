<?php

namespace Php\Form\Builder\Element;

class Time extends Input
{
    const TYPE = 'time';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
