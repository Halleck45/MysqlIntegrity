<?php

namespace Hal\Integrity;

use \Hal\Core\Database\Describer,
    \Hal\Core\Database\RequesterInterface,
    Hal\Core\Database\ConnectorInterface;

/**
 * class Hal\Integrity\CheckerAbstract
 *
 * @version 1
 * @package Hal\Integrity
 * @namespace Hal\Integrity
 * @implements Hal\Integrity\CheckerInterface
 */
abstract class CheckerAbstract implements CheckerInterface {

    /**
     * Describer
     * 
     * @var \Hal\Core\Database\Describer
     */
    protected $_describer;

    /**
     * Connector 
     * 
     * @var Hal\Core\Database\ConnectorInterface 
     */
    protected $_connector;

    /**
     * Requester 
     * 
     * @var \Hal\Core\Database\RequesterInterface
     */
    protected $_requester;

    /**
     * Constructor
     * 
     * @param \Hal\Core\Database\Describer $describer
     * @param \Hal\Core\Database\RequesterInterface $requester
     * @param \Hal\Integrity\ForeignKey\Hal\Core\Database\ConnectorInterface $connector
     */
    public function __construct(Describer $describer, RequesterInterface $requester, ConnectorInterface $connector) {
        $this->_connector = $connector;
        $this->_describer = $describer;
        $this->_requester = $requester;
    }

}