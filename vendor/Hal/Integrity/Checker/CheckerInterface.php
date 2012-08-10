<?php

namespace Hal\Integrity\Checker;

use \Hal\Core\Database\Describer,
    \Hal\Core\Database\RequesterInterface,
    Hal\Core\Database\ConnectorInterface;

/**
 * interface Hal\Integrity\CheckerInterface
 *
 * @version 1
 * @package Hal\Integrity\Checker
 * @namespace Hal\Integrity\Checker
 */
interface CheckerInterface {

    /**
     * Constructor
     * 
     * @param \Hal\Core\Database\Describer $describer
     * @param \Hal\Core\Database\RequesterInterface $requester
     * @param \Hal\Integrity\ForeignKey\Hal\Core\Database\ConnectorInterface $connector
     */
    public function __construct(Describer $describer, RequesterInterface $requester, ConnectorInterface $connector);

    /**
     * List failures of the given table
     * 
     * @param string $table
     * @return array
     */
    public function getFailuresOf($table);
}