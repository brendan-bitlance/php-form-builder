<?php

namespace Form\Validation;

class Required extends AbstractValidation
{
	public function __construct($message = 'Required')
	{
		parent::__construct($message);
	}

	protected function is_value_valid($value)
	{
		return strlen(trim($value)) > 0;
	}
}
