<?php

namespace Hal\Integrity\Rule\ForeignKey;

use Hal\Integrity\Checker\CheckerAbstract,
    Hal\Integrity\Context\Context;

/**
 * class Hal\Integrity\Rule\ForeignKey\Checker
 *
 * @version 1
 * @package Hal\Integrity\Rule\ForeignKey
 * @namespace Hal\Integrity\Rule\ForeignKey
 * @extends Hal\Integrity\CheckerAbstract
 */
Class Checker extends CheckerAbstract {

    /**
     * List failures of the given table
     * 
     * @param string $table
     * @return array
     */
    public function getFailuresOf($table) {

        $failures = array();

        try {
            $relations = $this->_describer->getRelationsOf($table);
            $primaryKeys = $this->_describer->getPrimaryKeyOf($table);
        } catch (\PDOException $e) {
            fwrite(\STDERR, sprintf('We cannot retrieve main informations about %s : %s', $table, $e->getMessage()).PHP_EOL);
            return array();
        }


        foreach ($relations['with'] as $relation) {

            $selectedCols = $relation['TABLE_NAME'] . '.' . $relation['COLUMN_NAME'];
            foreach ($primaryKeys as $pk) {
                $selectedCols .= ', ' . $relation['TABLE_NAME'] . '.' . $pk;
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
            } catch (\PDOException $e) {
                fwrite(\STDERR, sprintf('We cannot retrieve information about %s : %s', $table, $e->getMessage()) . PHP_EOL);
                return array();
            }

            if (sizeof($rowset) > 0) {
                $context = new Context($table, $relation);
                $failure = new Failure($context, $rowset);
                array_push($failures, $failure);
            }
        }

        return $failures;
    }

}