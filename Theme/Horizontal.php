<?php

namespace Php\Form\Builder\Theme;

use Php\Form\Builder\Builder;
use Php\Form\Builder\Element;
use Php\Form\Builder\Signature\Checkable;
use InvalidArgumentException;

class Horizontal extends Builder
{
    /**
     * @var Element\HTML
     */
    private $wrapper;

    /**
     * @var Element\HTML
     */
    private $buffer;

    /**
     * @var string
     */
    private $size;

    /**
     * @var int
     */
    private $control_cols;

    /**
     * @var string
     */
    private $control_class;

    /**
     * @var int
     */
    private $label_cols;

    /**
     * @var string
     */
    private $label_class;

    /**
     * @var string
     */
    private $offset_class;

    public function __construct(array $form_attributes = [], $control_cols = 9, $size = 'lg')
    {
        $control_cols = (int) $control_cols;
        if ($control_cols < 1 || $control_cols > 11) {
            throw new InvalidArgumentException('Control width must support a label (between 1 and 11)');
        }
        $this->size = $size;
        $this->control_cols = $control_cols;
        $this->control_class = "col-{$this->size}-{$this->control_cols}";
        $this->label_cols = 12 - $this->control_cols;
        $this->label_class = "control-label col-{$this->size}-{$this->label_cols}";
        $this->offset_class = "col-{$this->size}-offset-{$this->label_cols}";
        parent::__construct($form_attributes);
        $this->add_attribute('class', 'form-horizontal');
        $this->wrapper = new Element\HTML('div', Element\HTML::INNER_BLANK, ['class' => $this->control_class]);
        $this->buffer = new Element\HTML('div', Element\HTML::INNER_BLANK, ['class' => "{$this->control_class} {$this->offset_class}"]);
    }

    public function group_checkable($help = null, array $help_attributes = [], array $attributes = [])
    {
        $buffer = $this->buffer;
        if (is_string($help)) {
            $help = new Element\Help($help);
        }
        return $this->group($help, $help_attributes, $buffer, $attributes);
    }

    public function group($help = null, array $help_attributes = [], Element\HTML $buffer = null, array $attributes = [])
    {
        $classString = "{$this->control_class} {$this->offset_class}";
        if (is_string($help)) {
            $help = new Element\Help($help);
            $help->add_attribute('class', $classString);
        }
        return parent::group($help, $help_attributes + ['class' => $classString], $buffer, $attributes);
    }

    public function group_raw($help = null, array $help_attributes = [], Element\HTML $buffer = null, array $attributes = [])
    {
        return parent::group($help, $help_attributes, $buffer, $attributes);
    }

    public function pair(Element\Control $control, $label = null, array $attributes = [])
    {
        if (!($control instanceof Checkable)) {
            $control->set_wrapper($this->wrapper);
            if (!is_null($label)) {
                if (is_string($label)) {
                    $label = new Element\Label($label, ['class' => $this->label_class]);
                } elseif ($label instanceof Element\Label) {
                    $label->add_attribute('class', $this->label_class);
                }
            }
        }
        return parent::pair($control, $label, $attributes);
    }

    public function pair_raw(Element\Control $control, $label = null, array $attributes = [])
    {
        return parent::pair($control, $label, $attributes);
    }

    public function submit(array $attributes = [])
    {
        $this->close_group();
        $submit = new Element\Submit($attributes);
        $wrapper = clone $this->wrapper;
        $wrapper->add_attribute('class', $this->offset_class);
        $submit->set_wrapper($wrapper);
        $group = new Element\Group([new Element\Pair($submit)]);
        $group->add_attribute('class', 'submit');
        $this->add_group($group);
        return $this;
    }

    public function buttons(Element\Button $button, $_ = null)
    {
        $this->group();
        foreach (func_get_args() as $i => $b) {
            $b->add_attribute('style', 'margin-left: 15px');
            if ($i === 0) {
                $attributes = ['class' => "col-{$this->size}-offset-{$this->label_cols} pull-left"];
            } else {
                $attributes = ['class' => 'pull-left'];
            }
            $this->pair_raw($b, null, $attributes);
        }
        return $this;
    }
}
