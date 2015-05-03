<?php

namespace Form\Element;

use Form\Signature\HasControl;
use Form\Validation\AbstractValidation;

class Form extends HTML
{
	const NAME = 'form';
	const ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
	const ENCTYPE_MULTIPART = 'multipart/form-data';
	const ENCTYPE_TEXT = 'text/plain';

	/**
	 * @var array
	 */
	private $validation = array();

	public function __construct(array $attributes = array())
	{
		parent::__construct(self::NAME, array(), $attributes);
	}

	public function get_default_attributes()
	{
		return array(
			'method' => 'post',
			'enctype' => self::ENCTYPE_MULTIPART,
			'action' => ''
		);
	}

	public function add_line(HasControl $line)
	{
		$this->inner[] = $line;
	}

	public function set_lines(array $lines)
	{
		$this->inner = array();
		foreach ($lines as $line) {
			$this->add_line($line);
		}
	}

	public function add_validation($name, AbstractValidation $validation)
	{
		$this->validation[$name][] = $validation;
	}

	public function set_validation(array $validation)
	{
		$this->validation = array();
		foreach ($validation as $name => $rules) {
			if (!is_array($rules)) {
				$rules = array($rules);
			}
			foreach ($rules as $rule) {
				$this->add_validation($name, $rule);
			}
		}
	}

	/**
	 * @param array $data
	 * @param bool $validate
	 */
	public function populate(array $data, $validate = true)
	{
		foreach ($this->inner as &$line) {
			$line_controls = $line->get_controls();
			foreach ($line_controls as &$control) {
				$keys = $control->get_data_name_keys();
				$value = $data;
				$depth = 0;
				foreach ($keys as $key) {
					if (!empty($value[$key])) {
						$value = $value[$key];
					} else {
						break;
					}
					++$depth;
				}
				if ($depth > 0 && !is_null($value)) {
					$control->set_submitted_value($value);
				} else {
					$value = null;
				}
				if ($validate) {
					$errors = $this->validate_control($control, $value);
					if (!empty($errors)) {
						$control->get_group()->set_help($errors);
					}
				}
			}
		}
	}

	/**
	 * @param Control $control
	 * @param mixed $value
	 * @return array
	 */
	public function validate_control(Control &$control, $value)
	{
		$errors = array();
		$name = $control->get_data_name();
		if (array_key_exists($name, $this->validation)) {
			$in_error = false;
			foreach ($this->validation[$name] as $v) {
				if (!$v->is_valid($value)) {
					$in_error = true;
					$errors[] = $v->get_message();
				}
			}
			$control->get_group()->in_error($in_error);
		}
		return $errors;
	}

	/**
	 * @return bool
	 */
	public function is_valid()
	{
		return empty($this->errors);
	}
}
