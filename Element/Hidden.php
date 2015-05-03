<?php

namespace Form\Element;

class Hidden extends Input
{
	const TYPE = 'hidden';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}
}
