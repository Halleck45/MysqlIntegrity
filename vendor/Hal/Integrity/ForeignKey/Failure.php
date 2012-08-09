<?php

namespace Hal\Integrity\ForeignKey;

/**
 * class Hal\Integrity\ForeignKey\Failure
 *
 * @version 1
 * @package Hal\Integrity\ForeignKey
 * @namespace Hal\Integrity\ForeignKey
 */
Class Failure {

    /**
     * Relation
     * 
     * @var array
     */
    public $relation;

    /**
     * Rowset
     * 
     * @var array
     */
    public $rowset;

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

}