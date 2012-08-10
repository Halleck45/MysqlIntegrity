<?php

namespace Hal\Integrity\Rule\Corruption;

use Hal\Integrity\Failure\FailureAbstract;

/**
 * class Hal\Integrity\Rule\Corruption\Failure
 *
 * @version 1
 * @package Hal\Integrity\Rule\Corruption
 * @namespace Hal\Integrity\Rule\Corruption
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