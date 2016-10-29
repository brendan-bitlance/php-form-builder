<?php

namespace Php\Form\Builder\Element;

use Php\Form\Builder\Exception\UnknownControl;
use Php\Form\Builder\Signature\HasControl;

class Group extends HTML implements HasControl
{
    const NAME = 'div';

    /**
     * @var array
     */
    protected $pairs;

    /**
     * @var Help|null
     */
    protected $help;

    public function __construct(array $pairs = [], $help = null, array $attributes = [])
    {
        $this->set_pairs($pairs);
        if (!is_null($help)) {
            $this->set_help($help);
        }
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-group'
        ];
    }

    public function add_pair($pair)
    {
        if (!($pair instanceof Pair) && !($pair instanceof CheckablePair)) {
            throw new \InvalidArgumentException('Invalid pair');
        }
        $pair->get_control()->set_group($this);
        $this->pairs[] = $pair;
    }

    public function set_pairs(array $pairs)
    {
        $this->pairs = [];
        foreach ($pairs as $pair) {
            $this->add_pair($pair);
        }
    }

    public function get_control($name)
    {
        foreach ($this->pairs as &$pair) {
            if ($pair->has_control($name)) {
                return $pair->get_control();
            }
        }
        throw new UnknownControl($name);
    }

    public function get_controls()
    {
        $controls = [];
        foreach ($this->pairs as &$pair) {
            $controls[] = $pair->get_control();
        }
        return $controls;
    }

    public function has_control($name)
    {
        foreach ($this->pairs as &$pair) {
            if ($pair->has_control($name)) {
                return true;
            }
        }
        return false;
    }

    public function get_help()
    {
        return $this->help;
    }

    /**
     * @param string|Help|array $help
     * @throws \InvalidArgumentException
     */
    public function set_help($help)
    {
        if (is_string($help)) {
            $this->help = new Help($help);
        } elseif (is_array($help)) {
            $help_lines = [];
            foreach ($help as $i => $h) {
                if ($i > 0) {
                    $help_lines[] = new HTML('br', HTML::INNER_EMPTY);
                }
                $help_lines[] = new HTML('span', $h, ['class' => "line-{$i}"]);
            }
            $this->help = new Help($help_lines);
        } elseif ($help instanceof Help) {
            $this->help = $help;
        } else {
            throw new \InvalidArgumentException('Malformed help');
        }
    }

    /**
     * @param bool $flag
     */
    public function in_error($flag = true)
    {
        $aria_invalid = 'aria-invalid';
        if ($flag) {
            foreach ($this->pairs as &$pair) {
                $pair->get_control()->{$aria_invalid} = 'true';
            }
            $this->add_attribute('class', 'has-error');
        } else {
            foreach ($this->pairs as &$pair) {
                unset($pair->get_control()->{$aria_invalid});
            }
            $this->remove_attribute('class', 'has-error');
        }
    }

    public function generate_inner($tabs = 0)
    {
        $this->inner = $this->pairs;
        if (!is_null($this->help)) {
            $this->inner[] = $this->help;
        }
        return parent::generate_inner($tabs);
    }

}
