<?php

namespace Php\Form\Builder\Element;

class Url extends Input
{
    const TYPE = 'url';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
