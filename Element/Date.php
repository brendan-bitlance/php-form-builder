<?php

namespace Form\Element;

class Date extends Input
{
	const TYPE = 'date';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}
}
