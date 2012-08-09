<?php

namespace Hal\Core\Database;

/**
 * interface Hal\Database\Connector
 * @brief Manage db connection
 *
 * @author Jean-FranÃ§ois LÃ©pine
 * @date August 20111
 * @version 1
 * @package Hal\Core\Database
 * @namespace Hal\Core\Database
 */
interface ConnectorInterface {

    /**
     * Constructor
     * 
     * @param string $name
     * @param string $user
     * @param string $password
     * @param string $host
     * @param string $sgbd
     */
    public function __construct($name, $user, $password, $host = '', $sgbd = '');

    /**
     * Get the PDO instance
     *
     * @return \PDO
     */
    public function getPdo();

    /**
     * Get the current database name
     * 
     * @return string
     */
    public function getName();

    /**
     * Get the current database host
     * 
     * @return string
     */
    public function getHost();
}