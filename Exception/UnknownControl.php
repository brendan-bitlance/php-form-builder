<?php

namespace Php\Form\Builder\Exception;

class UnknownControl extends \OutOfRangeException
{
    public function __construct($name)
    {
        parent::__construct("Unknown control: {$name}");
    }
}
