<?php

/**
 * PHP form builder
 *
 * @author Brendan Markham
 * @copyright 2015
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version 0.0.1
 */

namespace Form;

use Form\Element;
use Form\Signature\Checkable;

class Builder
{
	/**
	 * @var Element\Form
	 */
	private $form;

	/**
	 * @var Element\Fieldset
	 */
	private $temp_fieldset;

	/**
	 * @var Element\Group
	 */
	private $temp_group;

	public function __construct(array $form_attributes = array())
	{
		$this->form = new Element\Form($form_attributes);
	}

	public function __call($name, $arguments)
	{
		return call_user_func_array(array($this->form, $name), $arguments);
	}

	public function fieldset($legend = null)
	{
		$this->close_fieldset();
		$this->close_group();
		$this->temp_fieldset = new Element\Fieldset(array(), $legend);
		return $this;
	}

	public function close_fieldset()
	{
		if ($this->temp_fieldset) {
			$this->close_group();
			$this->form->add_line($this->temp_fieldset);
			$this->temp_fieldset = null;
		}
		return $this;
	}

	public function group($help = null, array $attributes = array())
	{
		$this->close_group();
		$this->temp_group = new Element\Group(array(), $help, $attributes);
		return $this;
	}

	public function close_group()
	{
		if ($this->temp_group) {
			if ($this->temp_fieldset) {
				$this->add_group($this->temp_group);
			} else {
				$this->form->add_line($this->temp_group);
			}
			$this->temp_group = null;
		}
		return $this;
	}

	public function pair(Element\Control $control, $label = null)
	{
		if (!$this->temp_group) {
			$this->group();
		}
		if ($control instanceof Checkable) {
			$pair = new Element\CheckablePair($control, $label);
		} else {
			$pair = new Element\Pair($control, $label);
		}
		$this->temp_group->add_pair($pair);
		return $this;
	}

	public function submit(array $submit_attributes = array())
	{
		$this->close_group(); //<* Assume the current group (if any) can be finalised
		$group = new Element\Group(array(new Element\Pair(new Element\Submit($submit_attributes))));
		$group->add_attribute('class', 'submit');
		$this->add_group($group);
		return $this;
	}

	private function add_group(Element\Group $group)
	{
		if ($this->temp_fieldset) {
			$this->temp_fieldset->add_group($group);
		} else {
			$this->form->add_line($group);
		}
	}
}
