<?php

namespace Hal\Core\Database;

/**
 * class Hal\Database\Connector
 * @brief Manage db connection
 *
 * @author Jean-FranÃ§ois LÃ©pine
 * @date August 20111
 * @version 1
 * @package Hal\Core\Database
 * @namespace Hal\Core\Database
 * @implements ConnectorInterface
 */
class Connector implements ConnectorInterface {

    /**
     * PDO Instance
     * 
     * @var \PDO
     */
    private $_pdo;

    /**
     * Name
     * 
     * @var string
     */
    private $_name;

    /**
     * Host
     * 
     * @var string
     */
    private $_host;

    /**
     * Constructor
     * 
     * @param string $name
     * @param string $user
     * @param string $password
     * @param string $host
     * @param string $sgbd
     */
    public function __construct($name, $user, $password, $host = 'localhost', $sgbd = 'mysql') {
        $this->_name = $name;
        $this->_host = $host;
        $this->connect($name, $user, $password, $host, $sgbd);
    }

    /**
     * Connects
     *
     * @return void
     */
    public function connect($name, $user, $password, $host = 'localhost', $sgbd = 'mysql') {
        $dsn = $sgbd . ':dbname=' . $name . ';host=' . $host;
        try {
            $this->_pdo = new \PDO(
                            $dsn
                            , $user
                            , $password
            );
        } catch (Exception $e) {
            throw new Exception("Database error : config");
        }
        $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
        $this->_pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_UPPER); // windows
    }

    /**
     * Get the PDO instance
     *
     * @return PDO
     */
    public function getPdo() {
        return $this->_pdo;
    }

    /**
     * Get the current database name
     * 
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Get the current database host
     * 
     * @return string
     */
    public function getHost() {
        return $this->_host;
    }

}