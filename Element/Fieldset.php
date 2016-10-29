<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Exception\UnknownControl;
use Php\Form\Builder\Signature\HasControl;

class Fieldset extends HTML implements HasControl
{
    const NAME = 'fieldset';

    /**
     * @var array
     */
    private $groups = [];

    /**
     * @var Legend|null
     */
    private $legend;

    public function __construct(array $groups = [], $legend = null, array $attributes = [])
    {
        $this->set_groups($groups);
        if (is_string($legend)) {
            $this->legend = new Legend($legend);
        } elseif ($legend instanceof Legend || is_null($legend)) {
            $this->legend = $legend;
        } else {
            throw new \InvalidArgumentException('Malformed legend');
        }
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
    }

    public function add_group(Group $group)
    {
        $this->groups[] = $group;
    }

    public function set_groups(array $groups)
    {
        $this->groups = [];
        foreach ($groups as $group) {
            $this->add_group($group);
        }
    }

    public function get_control($name)
    {
        foreach ($this->groups as &$group) {
            if ($group->has_control($name)) {
                return $group->get_control();
            }
        }
        throw new UnknownControl($name);
    }

    public function get_controls()
    {
        $controls = [];
        foreach ($this->groups as &$group) {
            $controls = array_merge($controls, $group->get_controls());
        }
        return $controls;
    }

    public function has_control($name)
    {
        foreach ($this->groups as &$group) {
            if ($group->has_control($name)) {
                return true;
            }
        }
        return false;
    }

    public function generate_inner($tabs = 0)
    {
        $this->inner = $this->groups;
        if (!is_null($this->legend)) {
            array_unshift($this->inner, $this->legend);
        }
        return parent::generate_inner($tabs);
    }

}
