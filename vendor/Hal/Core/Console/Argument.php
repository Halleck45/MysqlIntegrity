<?php

namespace Hal\Core\Console;

class Argument {

    public function get($name) {
        $options = getopt('', array($name . ':'));
        return isset($options[$name]) ? $options[$name] : null;
    }

}
