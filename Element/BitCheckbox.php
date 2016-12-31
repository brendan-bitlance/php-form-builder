<?php

namespace Php\Form\Builder\Element;

class BitCheckbox extends Checkbox
{
    const TYPE = 'checkbox';

    /**
     * @var Checkbox
     */
    private $zero;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->zero = new Checkbox(['name' => $this->__get('name'), 'class' => 'zero', 'value' => 0, 'checked', 'tabindex' => -1]);
    }

    public function generate($tabs = 0)
    {
        return self::generate_tabs($tabs) . $this->zero . PHP_EOL . self::generate_tabs($tabs) . parent::generate();
    }
}
