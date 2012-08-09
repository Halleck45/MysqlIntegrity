<?php

namespace Hal\Core\Cache;

/**
 * @interface Hal\Core\Cache\CacheInterface
 *
 * @author Jean-FranÃ§ois Lépine
 * @date August 2011
 * @version 1
 * @package Hal\Core\Cache
 * @namespace Hal\Core\Cache
 */
interface CacheInterface {

    /**
     * Save element
     *
     * @param mixed $data
     * @param id $id
     * @return \Core\Cache\Memory
     */
    public function save($data, $id);

    /**
     * Get element
     *
     * @param string $id
     * @return mixed
     */
    public function get($id);

    /**
     * Check if the given element is registered
     *
     * @param string $id
     * @return boolean
     */
    public function isRegistered($id);

    /**
     * Cler cached element
     *
     * @param boolean $id
     * @return $this
     */
    public function clear($id);

    /**
     * Clear cache
     *
     * @return \Core\Cache\Memory
     */
    public function clearAll();
}