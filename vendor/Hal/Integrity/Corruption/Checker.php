<?php

namespace Hal\Integrity\Corruption;

use Hal\Integrity\CheckerAbstract;

/**
 * class Hal\Integrity\Corruption\Checker
 *
 * @version 1
 * @package Hal\Integrity\Corruption
 * @namespace Hal\Integrity\Corruption
 * @extends Hal\Integrity\CheckerAbstract
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