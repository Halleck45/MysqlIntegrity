<?php

namespace Hal\Integrity\Failure;

use Hal\Integrity\Context\ContextInterface;

/**
 * class Hal\Integrity\FailureAbstract
 *
 * @version 1
 * @package Hal\Integrity\Failure
 * @namespace Hal\Integrity\Failure
 * @implements Hal\Integrity\Failure\FailureInterface
 */
abstract class FailureAbstract implements FailureInterface {

    /**
     * Context
     * 
     * @var Hal\Integrity\Context\ContextInterface
     */
    protected $context;

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
    public function __construct(ContextInterface $relation, array $rowset) {
        $this->context = $relation;
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