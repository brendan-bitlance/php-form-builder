<?php

namespace Form\Element;

use Form\Signature\Selectable;

class Option extends HTML implements Selectable
{
	const NAME = 'option';

	public function __construct($value, $inner = null, array $attributes = array())
	{
		$attributes['value'] = $value;
		if (is_null($inner)) {
			$inner = $value;
		}
		parent::__construct(self::NAME, $inner, $attributes);
	}

	public function mark_selected(array $value)
	{
		if (in_array($this->value, $value)) {
			$this->selected = 'selected';
		} else {
			unset($this->selected);
		}
	}
}
