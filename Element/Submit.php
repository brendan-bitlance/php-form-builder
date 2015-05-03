<?php

namespace Form\Element;

class Submit extends Input
{
	const TYPE = 'submit';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}

	public function get_default_attributes()
	{
		return array(
			'class' => 'btn btn-primary',
			'value' => 'Submit'
		);
	}
}
