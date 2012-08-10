<?php

namespace Hal\Integrity\Rule\Corruption;

use Hal\Integrity\Checker\CheckerAbstract;

/**
 * class Hal\Integrity\Rule\Corruption\Checker
 *
 * @version 1
 * @package Hal\Integrity\Rules\Corruption
 * @namespace Hal\Integrity\Rule\Corruption
 * @extends Hal\Integrity\Rule\CheckerAbstract
 */
Class Checker extends CheckerAbstract {

    /**
     * List failures of the given table
     * 
     * @param string $table
     * @return array
     */
    public function getFailuresOf($table) {
        try {
            $this->_requester->getRowset(sprintf('Describe %s', $table));
        } catch (\PDOException $e) {
            if (false !== strpos($e->getMessage(), 'references invalid table(s) or column(s) or function(s)')) {
                $relation = $this->_describer->getRelationsOf($table);
                return array(new Failure($relation, array()));
            }
        }
        return array();
    }

}