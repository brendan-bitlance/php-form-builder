<?php

namespace Form\Element;

class Label extends HTML
{
	const NAME = 'label';

	public function __construct($inner, array $attributes = array())
	{
		parent::__construct(self::NAME, $inner, $attributes);
	}

	public function get_default_attributes()
	{
		return array(
			'class' => 'control-label'
		);
	}
}
