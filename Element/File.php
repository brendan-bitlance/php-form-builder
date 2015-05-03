<?php

namespace Form\Element;

class File extends Input
{
	const TYPE = 'file';

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::TYPE, $attributes);
	}
}
