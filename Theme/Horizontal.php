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
     * @var string
     */
    private $size;

    /**
     * @var int
     */
    private $control_width;

    /**
     * @var string
     */
    private $control_class;

    /**
     * @var int
     */
    private $label_width;

    /**
     * @var string
     */
    private $label_class;

    public function __construct(array $form_attributes = [], $control_width = 9, $size = 'lg')
    {
        $control_width = (int) $control_width;
        if ($control_width < 1 || $control_width > 11) {
            throw new InvalidArgumentException('Control width must support a label (between 1 and 11)');
        }
        $this->size = $size;
        $this->control_width = $control_width;
        $this->control_class = "col-{$this->size}-{$this->control_width}";
        $this->label_width = 12 - $this->control_width;
        $this->label_class = "control-label col-{$this->size}-{$this->label_width}";
        parent::__construct($form_attributes);
        $this->add_attribute('class', 'form-horizontal');
        $this->wrapper = new Element\HTML('div', Element\HTML::INNER_BLANK, ['class' => $this->control_class]);
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

    public function submit(array $submit_attributes = [])
    {
        $this->close_group();
        $submit = new Element\Submit($submit_attributes);
        $wrapper = clone $this->wrapper;
        $wrapper->add_attribute('class', "col-{$this->size}-offset-{$this->label_width}");
        $submit->set_wrapper($wrapper);
        $group = new Element\Group([new Element\Pair($submit)]);
        $group->add_attribute('class', 'submit');
        $this->add_group($group);
        return $this;
    }
}
