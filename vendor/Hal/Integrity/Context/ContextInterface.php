<?php

namespace Hal\Integrity\Context;

/**
 * class Hal\Integrity\Context\Context
 *
 * @version 1
 * @package Hal\Integrity\Context
 * @namespace Hal\Integrity\Context
 */
interface ContextInterface {

    /**
     * Constructor
     * 
     * @param string $table
     * @param array $map
     */
    public function __construct($table, array $map); 

    /**
     * Get the map of context
     * 
     * @return array
     */
    public function getMap();

    /**
     * Get the concerned table
     * 
     * @return string
     */
    public function getTable();
}