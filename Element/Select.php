<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Signature\Selectable;

class Select extends Control
{
    const NAME = 'select';

    /**
     * @var array
     */
    private $selected = [];

    public function __construct(array $options, $default_value = null, array $attributes = [])
    {
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
        $this->set_lines($options);
        if (!is_null($default_value)) {
            $this->set_submitted_value($default_value);
        }
    }

    public function get_value()
    {
        return $this->selected;
    }

    public function set_submitted_value($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }
        $this->selected = $value;
        foreach ($this->inner as $line) {
            $line->mark_selected($value);
        }
    }

    public function add_line(Selectable $line)
    {
        $this->inner[] = $line;
    }

    public function set_lines(array $lines)
    {
        $this->inner = [];
        foreach ($lines as $k => $v) {
            if (is_string($v) || is_null($v)) {
                $this->add_line(new Option($k, $v));
            } elseif (is_array($v)) {
                $this->add_line(new Optgroup($k, $v));
            } else {
                $this->add_line($v);
            }
        }
    }
}
