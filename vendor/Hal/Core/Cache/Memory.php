<?php

namespace Hal\Core\Cache;

/**
 * @class Cache
 * @brief Temporary cache
 *
 * @author Jean-François Lépine
 * @date 19 nov. 2010
 * @version 1
 * @package Hal\Core\Cache
 * @implements Hal\Core\Cache\CacheInterface
 */
class Memory implements CacheInterface{

    /**
     * Cached datas
     *
     * @var array
     */
    protected $_tCached = array();

    /**
     * Save element
     *
     * @param mixed $data
     * @param id $id
     * @return \Core\Cache\Memory
     */
    public function save($data, $id) {
        $id = (string) $id;
        $this->_tCached[$id] = $data;
        return $this;
    }

    /**
     * Get element
     *
     * @param string $id
     * @return mixed
     */
    public function get($id) {
        $id = (string) $id;
        $return = null;
        if (self::isRegistered($id)) {
            $return = $this->_tCached[$id];
        }
        return $return;
    }

    /**
     * Check if the given element is registered
     *
     * @param string $id
     * @return boolean
     */
    public function isRegistered($id) {
        $id = (string) $id;
        return isset($this->_tCached[$id]);
    }

    /**
     * Cler cached element
     *
     * @param boolean $id
     * @return $this
     */
    public function clear($id) {
        $id = (string) $id;
        if (self::isRegistered($id)) {
            unset($this->_tCached[$id]);
        }
        return $this;
    }

    /**
     * Clear cache
     *
     * @return \Core\Cache\Memory
     */
    public function clearAll() {
        $this->_tCached = array();
        return $this;
    }


}