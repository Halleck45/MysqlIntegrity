<?php

namespace Hal\Integrity;

/**
 * class Hal\Integrity\FailureAbstract
 *
 * @version 1
 * @package Hal\Integrity
 * @namespace Hal\Integrity
 * @implements Hal\Integrity\FailureInterface
 */
abstract class FailureAbstract implements FailureInterface {

    /**
     * Relation
     * 
     * @var array
     */
    protected $relation;

    /**
     * Rowset
     * 
     * @var array
     */
    protected $rowset;

    /**
     * Constructor
     * 
     * @param array $relation
     * @param array $rowset
     */
    public function __construct(array $relation, array $rowset) {
        $this->relation = $relation;
        $this->rowset = $rowset;
    }

    /**
     * Get the associated rowset
     * 
     * @return array
     */
    public function getRowset() {
        return $this->rowset;
    }

    /**
     * Get the relation map associated to this failure
     * 
     * @return array
     */
    public function getRelationMap() {
        return $this->relation;
    }

}