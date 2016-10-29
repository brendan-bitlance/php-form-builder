<?php

namespace Php\Form\Builder\Element;

class Text extends Input
{
    const TYPE = 'text';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
