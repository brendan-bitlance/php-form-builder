<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Exception\UnknownControl;
use Php\Form\Builder\Signature\HasControl;

class Pair implements HasControl
{
    const NAME = 'div';

    /**
     * @var Control
     */
    protected $control;

    /**
     * @var Label
     */
    protected $label;

    /**
     * @var HTML
     */
    protected $wrapper;

    public function __construct(Control $control, $label = null, array $attributes = [])
    {
        $this->control = $control;
        if (!is_null($label)) {
            if (is_string($label)) {
                $this->label = new Label($label);
            } elseif ($label instanceof Label) {
                $this->label = $label;
            } else {
                throw new \InvalidArgumentException('Malformed label');
            }
            if (isset($this->control->id)) {
                $this->label->for = $this->control->id;
            }
        }
        if (!empty($attributes)) {
            $this->wrapper = new HTML(self::NAME, HTML::INNER_BLANK, $attributes);
        }
    }

    public function get_control($name = null)
    {
        if (!is_null($name) && !$this->has_control($name)) {
            throw new UnknownControl($name);
        }
        return $this->control;
    }

    public function get_controls()
    {
        return [
            $this->control
        ];
    }

    public function has_control($name)
    {
        return $this->control->name == $name;
    }

    public function generate($tabs = 0)
    {
        $output = "";
        if ($this->wrapper) {
            $output = $this->wrapper->generate_open($tabs)
                    . PHP_EOL . $this->wrapper->generate_inner($tabs + 1);
        }
        if ($this->label) {
            $output .= $this->label->generate($tabs + 1) . PHP_EOL;
        }
        $output .= $this->control->generate($tabs + 1);
        if ($this->wrapper) {
            $output .= PHP_EOL . HTML::generate_tabs($tabs) . $this->wrapper->generate_close($tabs);
        }
        return $output;
    }
}
