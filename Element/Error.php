<?php

namespace Php\Form\Builder\Element;

class Error extends Help
{
    public function get_default_attributes()
    {
        return [
            'class' => 'help-block error'
        ];
    }
}
