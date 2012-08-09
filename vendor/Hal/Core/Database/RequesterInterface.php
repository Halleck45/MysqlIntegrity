<?php

namespace Hal\Core\Database;

/**
 * interface Hal\Core\Database\RequesterInterface
 * @brief Allows to request database
 *
 * @date August 2011
 * @version 1
 * @package Hal\Core\Database
 * @namespace Hal\Core\Database
 */
interface RequesterInterface {

    /**
     * Constructor
     * @param \Hal\Core\Database\ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector);

    /**
     * Get the connector
     * 
     * @return ConnectorInterface
     */
    public function getConnector();

    /**
     * Execute a query (delete...)
     * @param string $sql
     */
    public function exec($sql);

    /**
     * Execute a select query and return its result
     * @param string $sql
     * @return array
     */
    public function query($sql);

    /**
     * Get a simple associative array
     * @param string $sql
     * @return array
     */
    public function getAssociativeArray($sql);

    /**
     * Get a value from aquery
     * @param string $sql
     * @return string
     */
    public function get($sql);

    /**
     * Get a rowset
     * @param string $sql
     * @return array
     */
    public function getRowset($sql);

    /**
     * Get a row
     * @param string $sql
     * @return array
     */
    public function getRow($sql);

    /**
     * Get a column
     * @param string $sql
     * @return array
     */
    public function getColumn($sql);

    /**
     * Protect a string (alias of PDO->quote())
     * @uses PDO::quote()
     * @param string $string
     * @return string
     */
    public function protect($string);
}