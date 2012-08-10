<?php

namespace Hal\Integrity;

/**
 * class Hal\Integrity\Runner
 *
 * @version 1
 * @package Hal\Integrity
 * @namespace Hal\Integrity
 * @implements Hal\Integrity\FailureInterface
 */
class Runner {

    /**
     * Checkers to use
     * 
     * @var \SplObjectStorage
     */
    private $checkers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->checkers = new \SplObjectStorage();
    }

    /**
     * Add new checker
     * 
     * @param \Hal\Integrity\CheckerInterface $checker
     * @return \Hal\Integrity\Runner
     */
    public function add(CheckerInterface $checker) {
        $this->checkers->attach($checker);
        return $this;
    }

    /**
     * Get failures of the given table
     * 
     * @param string $table
     * @return traversable
     */
    public function getFailuresOf($table) {
        $failures = array();
        foreach ($this->checkers as $checker) {
            $failures = array_merge($failures, $checker->getFailuresOf($table));
        }
        return $failures;
    }

}