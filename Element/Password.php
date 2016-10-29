<?php

namespace Php\Form\Builder\Element;

class Password extends Input
{
    const TYPE = 'password';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
