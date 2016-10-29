<?php

namespace Php\Form\Builder\Element;

class Email extends Input
{
    const TYPE = 'email';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }
}
