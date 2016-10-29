<?php

namespace Php\Form\Builder\Element;

class Legend extends HTML
{
    const NAME = 'legend';

    public function __construct($inner, array $attributes = [])
    {
        parent::__construct(self::NAME, $inner, $attributes);
    }
}
