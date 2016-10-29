<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Signature\Selectable;

class Optgroup extends HTML implements Selectable
{
    const NAME = 'optgroup';

    public function __construct($label, array $options = [], array $attributes = [])
    {
        $attributes['label'] = $label;
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
        $this->set_lines($options);
    }

    public function mark_selected(array $value)
    {
        foreach ($this->inner as $line) {
            $line->mark_selected($value);
        }
    }

    public function add_line(Option $line)
    {
        $this->inner[] = $line;
    }

    public function set_lines(array $lines)
    {
        $this->inner = [];
        foreach ($lines as $k => $v) {
            if (is_string($v)) {
                $this->add_line(new Option($k, $v));
            } else {
                $this->add_line($v);
            }
        }
    }
}
