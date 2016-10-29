<?php

namespace Php\Form\Builder\Validation;

use Php\Form\Builder\Element\Control;

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
        if (!$min_exists && !$max_exists) {
            throw new \InvalidArgumentException('Min or max must contain a value');
        }
        if ($min_exists && $max_exists && $min > $max) {
            throw new \InvalidArgumentException('Min cannot be greater than max');
        }
        if ($min_exists && (!is_int($min) || $min < 1)) {
            throw new \InvalidArgumentException('Min must be empty or positive integer');
        } else {
            $this->min = $min;
        }
        if ($max_exists && (!is_int($max) || $max < 1)) {
            throw new \InvalidArgumentException('Max must be empty or positive integer');
        } else {
            $this->max = $max;
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
                $message .= "s";
            }
        }
        parent::__construct($message);
    }

    protected function is_value_valid($value)
    {
        $length = strlen($value);
        if ((!is_null($this->min) && $length < $this->min) ||
                (!is_null($this->max) && $length > $this->max)) {
            return false;
        }
        return true;
    }

    public function process_control(Control $control)
    {
        if (!is_null($this->max)) {
            $control->add_attribute('maxlength', $this->max);
        }
    }
}
