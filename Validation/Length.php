<?php

namespace Form\Validation;

class Length extends AbstractValidation
{
	/**
	 * @var int|null
	 */
	private $min = null;
	
	/**
	 * @var int|null
	 */
	private $max = null;

	public function __construct($min = null, $max = null, $message = null)
	{
		$min_exists = !is_null($min);
		$max_exists = !is_null($max);
		if ($min_exists && !is_int($min)) {
			throw new \InvalidArgumentException('Min must be empty or integer');
		} else {
			$this->min = $min;
		}
		if ($max_exists && !is_int($max)) {
			throw new \InvalidArgumentException('Max must be empty or integer');
		} else {
			$this->max = $max;
		}
		if (!$min_exists && !$max_exists) {
			throw new \InvalidArgumentException('Min or max must contain a value');
		}
		if ($min_exists && $max_exists && $min > $max) {
			throw new \InvalidArgumentException('Min cannot be greater than max');
		}
		if (is_null($message)) {
			$message = "Value must contain ";
			if ($min === $max) {
				$message .= "exactly {$min}";
			} else {
				if ($min_exists) {
					$message .= "at least {$min}";
					if ($max_exists) {
						$message .= " and ";
					}
				}
				if ($max_exists) {
					$message .= "no more than {$max}";
				}
			}
			$message .= " character";
			if ($min > 1 || $max > 1) {
				$message.= "s";
			}
		}
		parent::__construct($message);
	}

	protected function is_value_valid($value)
	{
		$length = strlen($value);
		if (!is_null($this->min) && $length < $this->min) {
			return false;
		}
		if (!is_null($this->max) && $length > $this->max) {
			return false;
		}
		return true;
	}
}
