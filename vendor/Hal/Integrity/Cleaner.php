<?php

namespace Hal\Integrity;

use \Hal\Core\Database\RequesterInterface,
    \Hal\Integrity\Failure\FailureInterface;

/**
 * class Hal\Integrity\Cleaner
 *
 * @version 1
 * @package Hal\Integrity
 * @namespace Hal\Integrity
 */
class Cleaner {

    /**
     * Requester
     * 
     * @var \Hal\Core\Database\RequesterInterface 
     */
    private $requester;

    /**
     * Constructor
     * 
     * @param \Hal\Core\Database\RequesterInterface $requester
     */
    public function __construct(RequesterInterface $requester) {
        $this->requester = $requester;
    }

    /**
     * Cleans the given table
     * 
     * @param string $table
     * @return  Hal\Integrity\Cleaner
     */
    public function clean(FailureInterface $failure) {

        switch (true) {
            case $failure instanceof Rule\ForeignKey\Failure:Checker:
                $this->requester->exec('Set FOREIGN_KEY_CHECKS = 0;');
                $query = sprintf('DELETE FROM %s WHERE 0 = 1', $failure->getContext()->getTable());
                foreach ($failure->getRowset() as $row) {
                    $query .= ' OR ( 1 = 1 ';
                    foreach ($row as $col => $value) {
                        $query.= sprintf(' AND %1$s = %2$s'
                                , $col
                                , $this->requester->protect($value)
                        );
                    }
                    $query .= ')';
                }
                $this->requester->exec($query);
                $this->requester->exec('Set FOREIGN_KEY_CHECKS = 1;');
                break;
        }
        return $this;
    }

}