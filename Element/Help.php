<?php

namespace Form\Element;

class Help extends HTML
{
	const NAME = 'p';

	public function __construct($inner, array $attributes = array())
	{
		parent::__construct(self::NAME, $inner, $attributes);
	}

	public function get_default_attributes()
	{
		return array(
			'class' => 'help-block'
		);
	}
}
