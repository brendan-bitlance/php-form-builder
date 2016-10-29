<?php

namespace Php\Form\Builder\Element;

class Tel extends Input
{
    const TYPE = 'tel';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
