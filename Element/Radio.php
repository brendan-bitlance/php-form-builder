<?php

namespace Form\Element;

use Form\Signature\Checkable;

class Radio extends Input implements Checkable
{
	const TYPE = 'radio';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}

	public function get_default_attributes()
	{
		return array(
			'value' => 1
		);
	}

	public function set_submitted_value($value)
	{
		if ($value == $this->value) {
			$this->checked = 'checked';
		}
	}
}
