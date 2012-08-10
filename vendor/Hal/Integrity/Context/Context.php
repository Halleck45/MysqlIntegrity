<?php

namespace Hal\Integrity\Context;

/**
 * class Hal\Integrity\Context\Context
 *
 * @version 1
 * @package Hal\Integrity\Context
 * @namespace Hal\Integrity\Context
 * @implements Hal\Integrity\Context\Interface
 */
class Context implements ContextInterface {

    /**
     * Map (relations ,etc)
     * 
     * @var array
     */
    private $map = array();

    /**
     * Table
     * @var string
     */
    private $table;

    /**
     * Constructor
     * 
     * @param string $table
     * @param array $map
     */
    public function __construct($table, array $map) {
        $this->table = $table;
        $this->map = $map;
    }

    /**
     * Get the map of context
     * 
     * @return array
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * Get the concerned table
     * 
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

}