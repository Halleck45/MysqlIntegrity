<?php

namespace Hal\Integrity\Corruption;

use Hal\Integrity\FailureAbstract;

/**
 * class Hal\Integrity\Corruption\Failure
 *
 * @version 1
 * @package Hal\Integrity\Corruption
 * @namespace Hal\Integrity\Corruption
 * @extends Hal\Integrity\FailureAbstract
 */
Class Failure extends FailureAbstract {

    /**
     * Get an explicit message
     * 
     * @return string
     */
    public function toString() {
        return sprintf('Table or view is corrupted : references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them'
                        , $this->relation['TABLE_NAME']
        );
    }

}