<?php

namespace Php\Form\Builder\Element;

class Recaptcha extends Control
{
    const NAME = 'div';

    public function __construct($key)
    {
        $attributes = [
            'data-sitekey' => $key
        ];
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'g-recaptcha'
        ];
    }

    public function get_value()
    {
        return null;
    }

    public function set_submitted_value($value)
    {
        return;
    }
}
