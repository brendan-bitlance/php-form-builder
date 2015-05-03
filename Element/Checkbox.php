<?php

namespace Form\Element;

use Form\Signature\Checkable;

class Checkbox extends Input implements Checkable
{
	const TYPE = 'checkbox';

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
		if (!empty($value)) {
			$this->checked = 'checked';
		}
	}
}
