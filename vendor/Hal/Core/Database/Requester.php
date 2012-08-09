<?php

namespace Hal\Core\Database;

/**
 * class Hal\Core\Database\Requester
 * @brief Allows to request database
 *
 * @date August 2011
 * @version 1
 * @package Hal\Core\Database
 * @namespace Hal\Core\Database
 * @implements Hal\Core\Database\RequesterInterface
 */
class Requester implements RequesterInterface {

    /**
     * Db Connector
     * @var ConnectorInterface 
     */
    protected $_connector;

    /**
     * Constructor
     * @param \Hal\Core\Database\ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector) {
        $this->_connector = $connector;
    }

    /**
     * Get the pdo instance
     * @uses Pdo_Connector::getPdo()
     * @return PDO
     */
    public function getPdo() {
        return $this->_connector->getPdo();
    }

    /**
     * Get the connector
     * 
     * @return ConnectorInterface
     */
    public function getConnector() {
        return $this->_connector;
    }

    /**
     * Error
     * @param PDO $oPdo
     */
    public function error(\PDO $oPdo) {
        $tErr = $oPdo->errorInfo();
        $sErrMsg = $tErr[2];
        throw new \Exception('Erreur SQL : ' . $sErrMsg);
    }

    /**
     * Execute a query (delete...)
     * @param string $sql
     */
    public function exec($sql) {
        $sql = (string) $sql;
        $oPdo = $this->getPdo();
        $rSet = $oPdo->exec($sql);
        if ($rSet === false) {
            return $this->error($oPdo);
        }
    }

    /**
     * Execute a select query and return its result
     * @param string $sql
     * @return array
     */
    public function query($sql) {
        $sql = (string) $sql;
        $oPdo = $this->getPdo();

        $rSth = $oPdo->query($sql);
        if ($rSth === false) {
            return $this->error($oPdo);
        }

        $tRowset = (array) $rSth->fetchAll(\PDO::FETCH_ASSOC);
        return $tRowset;
    }

    /**
     * Get a simple associative array
     * @param string $sql
     * @return array
     */
    public function getAssociativeArray($sql) {
        $tResult = array();
        $tRowset = $this->query($sql);
        if ($tRowset === false) {
            return false;
        }
        if (!empty($tRowset)) {
            $tKey = \array_keys($tRowset[0]);
            foreach ($tRowset as $row) {
                $tResult[$row[$tKey[0]]] = $row[$tKey[1]];
            }
        }

        unset($tRowset);
        return $tResult;
    }

    /**
     * Get a value from aquery
     * @param string $sql
     * @return string
     */
    public function get($sql) {
        $tRowset = $this->query($sql);
        if ($tRowset === false) {
            return false;
        }
        if (!empty($tRowset)) {
            $tKey = \array_keys($tRowset[0]);
            return $tRowset[0][$tKey[0]];
        }
        return null;
    }

    /**
     * Get a rowset
     * @param string $sql
     * @return array
     */
    public function getRowset($sql) {
        $tResult = array();
        $tRowset = $this->query($sql);
        if ($tRowset === false) {
            return array();
        }
        if (!empty($tRowset)) {
            $tResult = $tRowset;
        }
        return $tResult;
    }

    /**
     * Get a row
     * @param string $sql
     * @return array
     */
    public function getRow($sql) {
        $tRowset = $this->query($sql);
        if ($tRowset === false) {
            return false;
        }
        if (!empty($tRowset)) {
            return $tRowset[0];
        }
        return array();
    }

    /**
     * Get a column
     * @param string $sql
     * @return array
     */
    public function getColumn($sql) {
        $tResult = array();
        $tRowset = $this->query($sql);
        if ($tRowset === false) {
            return false;
        }
        if (!empty($tRowset)) {
            foreach ($tRowset as $tRow) {
                $tValues = \array_values($tRow);
                $value = isset($tValues[0]) ? $tValues[0] : null;
                $tResult[] = $value;
            }
        }
        unset($tRowset);
        return $tResult;
    }

    /**
     * Protect a string (alias of PDO->quote())
     * @uses PDO::quote()
     * @param string $string
     * @return string
     */
    public function protect($string) {
        return $this->getPdo()->quote($string);
    }

}