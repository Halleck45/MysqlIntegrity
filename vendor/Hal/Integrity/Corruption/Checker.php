<?php

namespace Hal\Integrity\Corruption;

use \Hal\Core\Database\Describer,
    \Hal\Core\Database\RequesterInterface,
    Hal\Core\Database\ConnectorInterface;

/**
 * class Hal\Integrity\Corruption\Checker
 *
 * @version 1
 * @package Hal\Integrity\Corruption
 * @namespace Hal\Integrity\Corruption
 */
Class Checker {

    /**
     * Describer
     * 
     * @var \Hal\Core\Database\Describer
     */
    private $_describer;

    /**
     * Connector 
     * 
     * @var Hal\Core\Database\ConnectorInterface 
     */
    private $_connector;

    /**
     * Requester 
     * 
     * @var \Hal\Core\Database\RequesterInterface
     */
    private $_requester;

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

    /**
     * List failures of the given table
     * 
     * @param string $table
     * @return array
     */
    public function getFailuresOf($table) {
        try {
            $rowset = $this->_requester->getRowset(sprintf('Select 1 From %s', $table));
        } catch (\PDOException $e) {
            if(false !== strpos($e->getMessage(), 'references invalid table(s) or column(s) or function(s)')) {
                $relation = $this->_describer->getRelationsOf($table);
                return array(new Failure($relation, array()));
            }
        }
        return array();
    }

}