<?php

namespace Form\Element;

class Legend extends HTML
{
	const NAME = 'legend';

	public function __construct($inner, array $attributes = array())
	{
		parent::__construct(self::NAME, $inner, $attributes);
	}
}
