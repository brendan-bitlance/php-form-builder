<?php

namespace Form\Element;

class HTML
{
	const INNER_EMPTY = null;
	const INNER_BLANK = '';

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * @var string|HTML|array|null
	 */
	protected $inner;

	public function __construct($name, $inner = self::INNER_EMPTY, array $attributes = array())
	{
		$this->name = $name;
		$this->inner = $inner;
		foreach (array_merge($this->get_default_attributes(), $attributes) as $k => $v) {
			if (is_numeric($k)) {
				$k = $v;
			}
			$this->attributes[$k] = $v;
		}
	}

	public function __get($name)
	{
		if (!$this->__isset($name)) {
			return null;
		}
		return $this->attributes[$name];
	}

	public function __set($name, $value)
	{
		$this->attributes[$name] = $value;
	}

	public function __isset($name)
	{
		return array_key_exists($name, $this->attributes);
	}

	public function __unset($name)
	{
		unset($this->attributes[$name]);
	}

	public function __toString()
	{
		return $this->generate();
	}

	/**
	 * @return array
	 */
	public function get_default_attributes()
	{
		return array();
	}

	/**
	 * @return mixed
	 */
	public function get_inner()
	{
		return $this->inner;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function add_attribute($key, $value)
	{
		$current_value = $this->__get($key);
		if ($current_value) {
			$this->__set($key, rtrim("{$current_value} {$value}"));
		} else {
			$this->__set($key, $value);
		}
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function set_attribute($key, $value)
	{
		$this->__set($key, $value);
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function remove_attribute($key, $value)
	{
		if ($this->__isset($key)) {
			$this->__set($key, rtrim(str_replace($value, "", $this->__get($key))));
		}
	}

	/**
	 * @param int $tabs
	 * @return string
	 */
	public function generate($tabs = 0)
	{
		return $this->generate_open($tabs) . $this->generate_inner($tabs). $this->generate_close($tabs);
	}

	/**
	 * @param int $tabs
	 * @return string
	 */
	public function generate_open($tabs = 0)
	{
		$inline_attributes = self::generate_inline($this->attributes);
		$output = self::generate_tabs($tabs) . "<{$this->name}";
		if (!empty($inline_attributes)) {
			$output .= " {$inline_attributes}";
		}
		if ($this->inner === self::INNER_EMPTY) {
			$output .= " />";
		} else {
			$output .= ">";
		}
		return $output;
	}

	/**
	 * @param int $tabs
	 * @return string
	 */
	public function generate_inner($tabs = 0)
	{
		$output = "";
		if ($this->inner instanceof self) {
			$output .= PHP_EOL . $this->inner->generate($tabs + 1) . PHP_EOL;
		} elseif (is_array($this->inner)) {
			foreach ($this->inner as $html) {
				$output .= PHP_EOL . $html->generate($tabs + 1);
			}
			$output .= PHP_EOL;
		} else {
			$output .= self::encode($this->inner);
		}
		return $output;
	}

	/**
	 * @param int $tabs
	 * @return string|void
	 */
	public function generate_close($tabs = 0)
	{
		$output = "";
		if ($this->inner instanceof self || is_array($this->inner)) {
			$output .= self::generate_tabs($tabs);
		}
		if ($this->inner !== self::INNER_EMPTY) {
			$output .= "</{$this->name}>";
		}
		return $output;
	}

	/**
	 * @param int $multiplier
	 * @return string
	 */
	public static function generate_tabs($multiplier)
	{
		return str_repeat("\t", $multiplier);
	}

	/**
	 * @param array $subject
	 * @return string
	 */
	public static function generate_inline(array $subject)
	{
		$inline = '';
		foreach ($subject as $k => $v) {
			$inline .= self::encode($k) . '="' . self::encode($v) . '" ';
		}
		return rtrim($inline);
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public static function encode($value)
	{
		return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
	}
}
