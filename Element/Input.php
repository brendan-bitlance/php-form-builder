<?php

namespace Form\Element;

abstract class Input extends Control
{
	const NAME = 'input';

	public function __construct($type, array $attributes = array())
	{
		$attributes['type'] = $type;
		parent::__construct(self::NAME, parent::INNER_EMPTY, $attributes);
	}

	public function get_value()
	{
		return $this->value;
	}

	public function set_submitted_value($value)
	{
		if (is_scalar($value)) {
			$this->value = $value;
		}
	}
}
