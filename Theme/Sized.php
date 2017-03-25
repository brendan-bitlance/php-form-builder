<?php

namespace Php\Form\Builder\Theme;

use Php\Form\Builder\Builder;
use Php\Form\Builder\Element;

class Sized extends Builder
{
    /**
     * @var string
     */
    private $input_size;

    public function __construct($input_size = 'input-lg', array $form_attributes = array())
    {
        parent::__construct($form_attributes);
        $this->input_size = $input_size;
    }

    public function pair(Element\Control $control, $label = null, array $attributes = [])
    {
        $control->add_attribute('class', $this->input_size);
        return parent::pair($control, $label, $attributes);
    }

    public function pair_raw(Element\Control $control, $label = null, array $attributes = [])
    {
        return parent::pair($control, $label, $attributes);
    }
}
