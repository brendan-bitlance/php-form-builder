<?php

namespace Form\Element;

class Text extends Input
{
	const TYPE = 'text';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}
}
