<?php

namespace Php\Form\Builder\Signature;

interface HasControl
{
    /**
     * @param string $name
     * @return bool
     */
    public function has_control($name);

    /**
     * @param string $name
     * @return Control
     */
    public function get_control($name);

    /**
     * @return array
     */
    public function get_controls();

    /**
     * @param int $tabs
     * @return string
     */
    public function generate($tabs = 0);
}
