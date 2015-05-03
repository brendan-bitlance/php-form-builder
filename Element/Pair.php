<?php

namespace Form\Element;

use Form\Exception\UnknownControl;
use Form\Signature\HasControl;

class Pair implements HasControl
{
	/**
	 * @var Control
	 */
	protected $control;

	/**
	 * @var Label
	 */
	protected $label;

	public function __construct(Control $control, $label = null)
	{
		$this->control = $control;
		if (!is_null($label)) {
			if (is_string($label)) {
				$this->label = new Label($label);
			} elseif ($label instanceof Label) {
				$this->label = $label;
			} else {
				throw new \InvalidArgumentException('Malformed label');
			}
			if (isset($this->control->id)) {
				$this->label->for = $this->control->id;
			}
		}
	}

	public function get_control($name = null)
	{
		if (!is_null($name) && !$this->has_control($name)) {
			throw new UnknownControl($name);
		}
		return $this->control;
	}

	public function get_controls()
	{
		return array(
			$this->control
		);
	}

	public function has_control($name)
	{
		return $this->control->name == $name;
	}

	public function generate($tabs = 0)
	{
		$output = "";
		if ($this->label) {
			$output .= $this->label->generate($tabs) . PHP_EOL;
		}
		$output .= $this->control->generate($tabs);
		return $output;
	}
}
