<?php

namespace Hal\Core\Database;

use \Hal\Core\Cache\CacheInterface;

/**
 * class Hal\Core\Database\Describer
 *
 * @date August 2011
 * @version 1
 * @package Hal\Core\Database
 * @namespace Hal\Core\Database
 */
class Describer {

    /**
     * Requester object
     * 
     * @var Hal\Core\Database\RequesterInterface 
     */
    private $_requester;
    private $_cache;

    /**
     * Constructor
     * 
     * @param \Hal\Core\Database\RequesterInterface $requester
     * @param \Hal\Core\Cache\CacheInterface $cache
     */
    public function __construct(RequesterInterface $requester, CacheInterface $cache) {
        $this->_requester = $requester;
        $this->_cache = $cache;
    }

    /**
     * Describe a table
     *
     * @param string $sTableName
     * @return array
     */
    public function describe($sTableName) {
        $sCacheName = "descr-" . $sTableName;
        if ($this->_cache->isRegistered($sCacheName)) {
            $tRowset = $this->_cache->get($sCacheName);
        } else {
            $sql = 'DESCRIBE ' . $sTableName;
            $tRowset = $this->_requester->getRowset($sql);
            $this->_cache->save($tRowset, $sCacheName);
        }
        return $tRowset;
    }

    /**
     * Get all relationships
     *
     * @return array
     */
    public function getAllRelations() {

        $sCacheName = "descr-all-relations";
        if ($this->_cache->isRegistered($sCacheName)) {
            $tRowset = $this->_cache->get($sCacheName);
        } else {

            $sql = "SELECT * FROM INFORMATION_SCHEMA.key_column_usage
WHERE referenced_table_schema = '" . $this->_requester->getConnector()->getName() . "'
AND referenced_table_name IS NOT NULL
ORDER BY table_name, column_name";
            $tRowset = $this->_requester->getRowset($sql);
            $this->_cache->save($tRowset, $sCacheName);
        }

        return $tRowset;
    }

    /**
     * Get relationships of one table
     *
     * @use Database_Table_Describe::getAllRelations()
     * @param string $sTableName
     * @return array array[with=>array(), 'referencedBy'=>array()]
     */
    public function getRelationsOf($sTableName) {
        $tAllRelations = $this->getAllRelations();
        $tTableRelations = array('with' => array(), 'referencedBy' => array());
        foreach ($tAllRelations as $relation) {
            if ($relation['TABLE_NAME'] === $sTableName) {
                $tTableRelations['with'][] = $relation;
            }
            if ($relation['REFERENCED_TABLE_NAME'] === $sTableName) {
                $tTableRelations['referencedBy'][] = $relation;
            }
        }

        return $tTableRelations;
    }

    /**
     * Check if the given table is a view
     *
     * @param string $sTableName
     * @return boolean
     */
    public function isView($sTableName) {
        $sCacheName = "isview-" . $sTableName;
        if ($this->_cache->isRegistered($sCacheName)) {
            $nCount = $this->_cache->get($sCacheName);
        } else {
            $sql = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_NAME = '$sTableName' AND TABLE_TYPE = 'VIEW'";
            $nCount = (int) $this->_requester->get($sql);
            $this->_cache->save($nCount, $sCacheName);
        }

        return $nCount > 0;
    }

    /**
     * Get information schema
     *
     * @return array
     */
    public function getAllInformationSchema() {

        $sCacheName = "info-schema";
        if ($this->_cache->isRegistered($sCacheName)) {
            $tRowset = $this->_cache->get($sCacheName);
        } else {
            $sql = "SELECT * FROM information_schema.`TABLES` WHERE TABLE_SCHEMA = '" . $this->_requester->getConnector()->getName() . "'";
            $tRowset = $this->_requester->getRowset($sql);
            $this->_cache->save($tRowset, $sCacheName);
        }

        return $tRowset;
    }

    /**
     * Get information schrma of table
     *
     * @param string $sTableName
     * @return array
     */
    public function getInformationSchemaOfTable($sTableName) {
        $tInfoSchema = $this->getAllInformationSchema();
        foreach ($tInfoSchema as $schema) {
            if ($schema['TABLE_NAME'] == $sTableName) {
                return $schema;
            }
        }
        return array();
    }

    /**
     * Get the description of any table
     *
     * @param string $sTableName
     * @return string
     */
    public function getTableDescription($sTableName) {
        $tSchema = $this->getInformationSchemaOfTable($sTableName);
        return $tSchema['TABLE_COMMENT'];
    }

    /**
     * get information schema for columns
     *
     * @return array
     */
    public function getAllColumnsInformationSchema() {

        $sCacheName = "info-schema-columns";
        if ($this->_cache->isRegistered($sCacheName)) {
            $tRowset = $this->_cache->get($sCacheName);
        } else {
            $sql = "SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA = '" . $this->_requester->getConnector()->getName() . "'";
            $tRowset = $this->_requester->getRowset($sql);
            $this->_cache->save($tRowset, $sCacheName);
        }

        return $tRowset;
    }

    /**
     * Get information schema of the given column
     *
     * @param string $sTableName
     * @param string $sColumnName
     * @return array
     */
    public function getColumnInformationSchema($sTableName, $sColumnName) {
        $tInfoSchema = $this->getAllColumnsInformationSchema();
        foreach ($tInfoSchema as $schema) {
            if ($schema['COLUMN_NAME'] == $sColumnName && $schema['TABLE_NAME'] == $sTableName) {
                return $schema;
            }
        }
        return array();
    }

    /**
     * List the primary keys of a table
     *
     * @param string $sTableName
     * return array
     */
    public function getPrimaryKeyOf($sTableName) {
        $tPk = array();
        $tInfos = $this->describe($sTableName);
        foreach ($tInfos as $column) {
            if ($column['KEY'] == 'PRI') {
                \array_push($tPk, $column['FIELD']);
            }
        }
        return $tPk;
    }

    /**
     * List all tables
     *
     * @return array
     */
    public function listTables() {
        $sCacheName = "list-tables";
        if ($this->_cache->isRegistered($sCacheName)) {
            $tTables = $this->_cache->get($sCacheName);
        } else {
            $tTables = $this->_requester->getColumn("SHOW TABLES");
            $this->_cache->save($tTables, $sCacheName);
        }

        return $tTables;
    }

}
