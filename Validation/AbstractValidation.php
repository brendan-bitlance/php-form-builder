<?php

namespace Form\Validation;

abstract class AbstractValidation
{
	/**
	 * @var string
	 */
	protected $message = 'Invalid value';

	public function __construct($message = null)
	{
		if (!is_null($message)) {
			$this->message = (string) $message;
		}
	}

	/**
	 * @param mixed $values
	 * @return bool
	 */
	public function is_valid($values)
	{
		if (!is_array($values)) {
			$values = array($values);
		}
		foreach ($values as $value) {
			if (!$this->is_value_valid($value)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @return string
	 */
	public function get_message()
	{
		return $this->message;
	}

	/**
	 * @return bool
	 */
	abstract protected function is_value_valid($value);
}
