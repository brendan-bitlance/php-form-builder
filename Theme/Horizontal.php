<?php

namespace Php\Form\Builder\Theme;

use Php\Form\Builder\Builder;
use Php\Form\Builder\Element;
use Php\Form\Builder\Signature\Checkable;

class Horizontal extends Builder
{
    /**
     * @var Element\HTML
     */
    private $wrapper;

    /**
     * @var string
     */
    private $label_class;

    /**
     * @todo Simplify column management
     */
    public function __construct(array $form_attributes = [], $control_class = 'col-lg-9', $label_class = 'control-label col-lg-3')
    {
        parent::__construct($form_attributes);
        $this->add_attribute('class', 'form-horizontal');
        $this->wrapper = new Element\HTML('div', Element\HTML::INNER_BLANK, ['class' => $control_class]);
        $this->label_class = $label_class;
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

    public function submit(array $submit_attributes = [], $additional_control_class = 'col-lg-offset-3')
    {
        $this->close_group();
        $submit = new Element\Submit($submit_attributes);
        $wrapper = clone $this->wrapper;
        $wrapper->add_attribute('class', $additional_control_class);
        $submit->set_wrapper($wrapper);
        $group = new Element\Group([new Element\Pair($submit)]);
        $group->add_attribute('class', 'submit');
        $this->add_group($group);
        return $this;
    }
}
