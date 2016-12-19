<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Signature\HasControl;
use Php\Form\Builder\Validation\AbstractValidation;

class Form extends HTML
{
    const NAME = 'form';
    const ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    const ENCTYPE_MULTIPART = 'multipart/form-data';
    const ENCTYPE_TEXT = 'text/plain';

    /**
     * @var array
     */
    private $validation = [];

    /**
     * Innocent until proven guilty
     * @var bool
     */
    private $is_valid = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct(self::NAME, [], $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'method' => 'post',
            'enctype' => self::ENCTYPE_MULTIPART,
            'action' => ''
        ];
    }

    public function add_line(HasControl $line)
    {
        $this->inner[] = $line;
    }

    public function set_lines(array $lines)
    {
        $this->inner = [];
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
        $this->validation = [];
        foreach ($validation as $name => $rules) {
            if (!is_array($rules)) {
                $rules = [$rules];
            }
            foreach ($rules as $rule) {
                $this->add_validation($name, $rule);
            }
        }
    }

    /**
     * @param array $data
     * @param array $errors
     */
    public function populate(array $data, $validate = true)
    {
        $is_valid = true;
        $all_errors = [];
        foreach ($this->inner as &$line) {
            $line_controls = $line->get_controls();
            foreach ($line_controls as &$control) {
                $keys = $control->get_data_name_keys();
                $value = $data;
                $depth = 0;
                foreach ($keys as $key) {
                    if (array_key_exists($key, $value)) {
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
                        $is_valid = false;
                        $control->get_group()->set_help($errors);
                        $all_errors[$control->get_data_name()] = $errors;
                    }
                }
            }
        }
        $this->is_valid = $is_valid;
        return $all_errors;
    }

    /**
     * @param Control $control
     * @param mixed $value
     * @return array
     */
    public function validate_control(Control &$control, $value)
    {
        $errors = [];
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
        return $this->is_valid;
    }

    /**
     * @todo Try to break this lazy loading of validation
     * @param int $tabs
     * @return string
     */
    public function generate($tabs = 0)
    {
        foreach ($this->inner as &$line) {
            $line_controls = $line->get_controls();
            foreach ($line_controls as &$control) {
                if (array_key_exists($control->get_data_name(), $this->validation)) {
                    foreach ($this->validation[$control->get_data_name()] as $v) {
                        $v->process_control($control);
                    }
                }
            }
        }
        return parent::generate($tabs);
    }

}
