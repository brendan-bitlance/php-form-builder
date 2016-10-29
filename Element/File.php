<?php

namespace Php\Form\Builder\Element;

class File extends Input
{
    const TYPE = 'file';

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::TYPE, $attributes);
    }

    public function get_default_attributes()
    {
        return [];
    }
}
