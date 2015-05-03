<?php

namespace Form\Element;

use Form\Element\Group;

abstract class Control extends HTML
{
	private static $id_count = 0;

	/**
	 * @var Group
	 */
	private $group;

	public function __construct($name, $inner = parent::INNER_EMPTY, array $attributes = array())
	{
		parent::__construct($name, $inner, $attributes);
		if (!isset($this->id)) {
			$this->id = self::generate_id();
		}
	}

	public function get_default_attributes()
	{
		return array(
			'class' => 'form-control'
		);
	}

	/**
	 * @return Group
	 */
	public function get_group()
	{
		return $this->group;
	}

	/**
	 * @param Group $group
	 */
	public function set_group(Group $group)
	{
		$this->group = $group;
	}

	/**
	 * @return mixed
	 */
	abstract public function get_value();

	/**
	 * @param mixed $value
	 */
	abstract public function set_submitted_value($value);

	/**
	 * @return bool
	 */
	public function is_multiple()
	{
		$name_attribute = $this->__get('name');
		return strpos($name_attribute, '[') !== false && strrpos($name_attribute, ']') !== false;
	}

	/**
	 * @return string
	 */
	public function get_data_name()
	{
		$name_attribute = $this->__get('name');
		if ($this->is_multiple()) {
			return substr($name_attribute, 0, strpos($name_attribute, '['));
		}
		return $name_attribute;
	}

	/**
	 * @return array
	 */
	public function get_data_name_keys()
	{
		$keys = array(
			$this->get_data_name()
		);
		if ($this->is_multiple()) {
			$name_attribute = $this->__get('name');
			while ($name_attribute) {
				$open = strpos($name_attribute, '[');
				$start = $open + 1;
				$end = strpos($name_attribute, ']', $start);
				if ($open === false || $end === false || $end - $start < 0) {
					break;
				}
				$keys[] = substr($name_attribute, $start, $end - $start);
				$name_attribute = substr($name_attribute, $end + 1);
			}
		}
		return $keys;
	}

	/**
	 * @return string
	 */
	public static function generate_id()
	{
		return 'control-' . ++self::$id_count;
	}
}
