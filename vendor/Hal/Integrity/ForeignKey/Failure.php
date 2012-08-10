<?php

namespace Hal\Integrity\ForeignKey;

use Hal\Integrity\FailureAbstract;

/**
 * class Hal\Integrity\ForeignKey\Failure
 *
 * @version 1
 * @package Hal\Integrity\ForeignKey
 * @namespace Hal\Integrity\ForeignKey
 * @extends Hal\Integrity\FailureAbstract
 */
Class Failure extends FailureAbstract {

    /**
     * Get an explicit message
     * 
     * @return string
     */
    public function toString() {
        $string = sprintf('Table %1$s has corrupted relation with %2$s'
                , $this->relation['TABLE_NAME']
                , $this->relation['REFERENCED_TABLE_NAME']
        );
        foreach ($this->rowset as $row) {
            $string .= \PHP_EOL;
            foreach ($row as $col => $value) {
                $string .= sprintf("\t%s: %s", $col, $value);
            }
        }
        return $string;
    }

}