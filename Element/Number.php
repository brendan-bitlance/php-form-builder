<?php

namespace Form\Element;

class Number extends Input
{
	const TYPE = 'number';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}

	public function get_default_attributes()
	{
		return array(
			'class' => 'form-control',
			'value' => 0,
			'min' => 0
		);
	}
}
