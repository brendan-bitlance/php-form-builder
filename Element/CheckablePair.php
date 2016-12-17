<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Signature\Checkable;
use Php\Form\Builder\Signature\HasControl;

class CheckablePair extends HTML implements HasControl
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

    public function __construct(Checkable $control, $label, array $attributes = [])
    {
        if (is_null($label)) {
            throw new \InvalidArgumentException('Label is required');
        }
        $this->control = $control;
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
        if (!empty($attributes)) {
            $this->wrapper = new HTML(self::NAME, parent::INNER_BLANK, $attributes);
        }
        parent::__construct(self::NAME, parent::INNER_BLANK, []);
    }

    public function get_default_attributes()
    {
        return [
            'class' => $this->control->type
        ];
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

    public function generate_inner($tabs = 0)
    {
        $output = PHP_EOL . $this->label->generate_open($tabs + 1)
                . PHP_EOL . $this->control->generate($tabs + 2)
                . PHP_EOL . parent::generate_tabs($tabs + 2) . $this->label->generate_inner($tabs + 2)
                . PHP_EOL . parent::generate_tabs($tabs + 1) . $this->label->generate_close($tabs + 1)
                . PHP_EOL . parent::generate_tabs($tabs);
        return $output;
    }

    public function generate($tabs = 0)
    {
        $output = "";
        if ($this->wrapper) {
            $output = $this->wrapper->generate_open($tabs)
                    . PHP_EOL . $this->wrapper->generate_inner(++$tabs);
        }
        $output .= parent::generate($tabs);
        if ($this->wrapper) {
            --$tabs;
            $output .= PHP_EOL . parent::generate_tabs($tabs) . $this->wrapper->generate_close($tabs);
        }
        return $output;
    }
}
