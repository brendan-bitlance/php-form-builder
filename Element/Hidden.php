<?php

namespace Php\Form\Builder\Element;

class Hidden extends Input
{
    const TYPE = 'hidden';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
