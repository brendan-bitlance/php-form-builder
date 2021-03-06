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

    /**
     * @var array
     */
    protected $help_attributes = [];

    /**
     * @var HTML|null
     */
    protected $buffer;

    public function __construct(array $pairs = [], $help = null, $help_attributes = [], HTML $buffer = null, array $attributes = [])
    {
        $this->set_pairs($pairs);
        if (!is_null($help)) {
            $this->set_help($help);
        }
        $this->help_attributes = $help_attributes;
        $this->buffer = $buffer;
        parent::__construct(self::NAME, parent::INNER_BLANK, $attributes);
    }

    public function get_default_attributes()
    {
        return [
            'class' => 'form-group'
        ];
    }

    /**
     * @return HTML|null
     */
    public function get_buffer()
    {
        return $this->buffer;
    }

    /**
     * @param HTML|null $buffer
     */
    public function set_buffer(HTML $buffer = null)
    {
        $this->buffer = $buffer;
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
        foreach ($this->help_attributes as $k => $v) {
            $this->help->add_attribute($k, $v);
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
        $output = "";
        if ($this->buffer) {
            $output = PHP_EOL . $this->buffer->generate_open(++$tabs)
                    . PHP_EOL . $this->buffer->generate_inner($tabs);
        }
        $this->inner = $this->pairs;
        if (!is_null($this->help)) {
            $this->inner[] = $this->help;
        }
        $output .= parent::generate_inner($tabs);
        if ($this->buffer) {
            --$tabs;
            $output .= parent::generate_tabs($tabs + 1) . $this->buffer->generate_close($tabs) . PHP_EOL;
        }
        return $output;
    }
}
