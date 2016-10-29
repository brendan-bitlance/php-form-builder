<?php

/**
 * PHP form builder
 *
 * @author      Brendan Markham
 * @copyright   2016
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @version     1.0.0
 */

namespace Php\Form\Builder;

use Php\Form\Builder\Element;
use Php\Form\Builder\Signature\Checkable;

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

    public function __construct(array $form_attributes = [])
    {
        $this->form = new Element\Form($form_attributes);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->form, $name], $arguments);
    }

    public function __get($name)
    {
        return $this->form->{$name};
    }

    public function __set($name, $value)
    {
        return $this->form->{$name} = $value;
    }

    /**
     * @return Element\Form
     */
    public function get_form()
    {
        return $this->form;
    }

    public function fieldset($legend = null, array $attributes = [])
    {
        $this->close_fieldset();
        $this->close_group();
        $this->temp_fieldset = new Element\Fieldset([], $legend, $attributes);
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

    public function group($help = null, array $attributes = [])
    {
        $this->close_group();
        $this->temp_group = new Element\Group([], $help, $attributes);
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

    public function pair(Element\Control $control, $label = null, array $attributes = [])
    {
        if (!$this->temp_group) {
            $this->group();
        }
        if ($control instanceof Checkable) {
            $pair = new Element\CheckablePair($control, $label, $attributes);
        } else {
            $pair = new Element\Pair($control, $label, $attributes);
        }
        $this->temp_group->add_pair($pair);
        return $this;
    }

    public function submit(array $submit_attributes = [])
    {
        $this->close_group(); //<* Assume the current group (if any) can be finalised
        $group = new Element\Group([new Element\Pair(new Element\Submit($submit_attributes))]);
        $group->add_attribute('class', 'submit');
        $this->add_group($group);
        return $this;
    }

    public function generate($tabs = 0)
    {
        $this->finalise();
        return $this->form->generate($tabs);
    }

    public function finalise()
    {
        $this->close_group();
        $this->close_fieldset();
    }

    protected function add_group(Element\Group $group)
    {
        if ($this->temp_fieldset) {
            $this->temp_fieldset->add_group($group);
        } else {
            $this->form->add_line($group);
        }
    }
}
