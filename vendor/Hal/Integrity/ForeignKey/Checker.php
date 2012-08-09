<?php

namespace Hal\Integrity\ForeignKey;

use \Hal\Core\Database\Describer,
    \Hal\Core\Database\RequesterInterface,
    Hal\Core\Database\ConnectorInterface;

/**
 * class Hal\Integrity\ForeignKey\Checker
 *
 * @version 1
 * @package Hal\Integrity\ForeignKey
 * @namespace Hal\Integrity\ForeignKey
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

        $failures = array();

        $relations = $this->_describer->getRelationsOf($table);
        $primaryKeys = $this->_describer->getPrimaryKeyOf($table);
        foreach ($relations['with'] as $relation) {
            
            $selectedCols = $relation['TABLE_NAME'].'.'.$relation['COLUMN_NAME'];
            foreach($primaryKeys as $pk) {
                $selectedCols .= ', '.$relation['TABLE_NAME'].'.'.$pk;
            }
            
            $query = sprintf('Select %7$s From %1$s.%2$s Left Join %3$s.%4$s ON %1$s.%2$s.%5$s = %3$s.%4$s.%6$s Where %3$s.%4$s.%6$s Is Null'
                    , $this->_connector->getName()
                    , $table
                    , $relation['REFERENCED_TABLE_SCHEMA']
                    , $relation['REFERENCED_TABLE_NAME']
                    , $relation['COLUMN_NAME']
                    , $relation['REFERENCED_COLUMN_NAME']
                    , $selectedCols
            );
            try {
                $rowset = $this->_requester->getRowset($query);
            } catch (\Exception $e) {
                fwrite(\STDERR, PHP_EOL . sprintf('We cannot retrieve information about %s : %s', $table, $e->getMessage()));
                return array();
            }

            if (sizeof($rowset) > 0) {
                $failure = new Failure($relation, $rowset);
                array_push($failures, $failure);
            }
        }

        return $failures;
    }

}