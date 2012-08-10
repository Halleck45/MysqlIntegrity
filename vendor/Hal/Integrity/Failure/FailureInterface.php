<?php

namespace Hal\Integrity\Failure;

/**
 * interface Hal\Integrity\FailureInterface
 *
 * @version 1
 * @package Hal\Integrity\Failure
 * @namespace Hal\Integrity\Failure
 */
interface FailureInterface {

    /**
     * Constructor
     * 
     * @param array $relation
     * @param array $rowset
     */
    public function __construct(array $relation, array $rowset);

    /**
     * Get an explicit message
     * 
     * @return string
     */
    public function toString();

    /**
     * Get the associated rowset
     * 
     * @return array
     */
    public function getRowset();

    /**
     * Get the relation map associated to this failure
     * 
     * @return array
     */
    public function getRelationMap();
}