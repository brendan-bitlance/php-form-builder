<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Signature\Selectable;

class Option extends HTML implements Selectable
{
    const NAME = 'option';

    public function __construct($value, $inner = null, array $attributes = [])
    {
        $attributes['value'] = $value;
        if (is_null($inner)) {
            $inner = $value;
        }
        parent::__construct(self::NAME, $inner, $attributes);
    }

    public function mark_selected(array $value)
    {
        if (in_array($this->value, $value)) {
            $this->selected = 'selected';
        } else {
            unset($this->selected);
        }
    }
}
