<?php

namespace Integrity;

require_once 'autoload.php';

use \Hal\Core\Console\Argument,
    Hal\Core\Database\Connector as Connector,
    Hal\Core\Database\Requester as Requester,
    \Hal\Core\Database\Describer;

if ($argc <= 1) {
    $help = <<<EOT
   
Detects (and repairs) invalid foreign keys in mysql databases
by Jean-François Lépine <blog.lepine.pro>
@BETA

Usage:
   php integrity.php 
        --name=dbname               name of the database
        --user=username             mysql user
        --password=abc123           mysql password
        --host=localhost            host
        --action=list|clean         expected behavior (default:list)
                                    list: list all failures
                                    clean: remove failures

EOT;
    die($help);
}



//
// Database connexion
$connector = new Connector(
                Argument::get('name')
                , Argument::get('user')
                , Argument::get('password')
                , Argument::get('host')
);

//
// Database requester
$requester = new Requester($connector);

//
// Cache
$cache = new \Hal\Core\Cache\Memory;

//
// Database describer
$describer = new Describer($requester, $cache);


//
// Checker
$checker = new \Hal\Integrity\Runner();
$checker
//        ->add(new \Hal\Integrity\ForeignKey\Checker($describer, $requester, $connector))
        ->add(new \Hal\Integrity\Corruption\Checker($describer, $requester, $connector))
;

//
// Main program
$tables = $describer->listTables();
switch (Argument::get('action')) {
    case 'clean':
        foreach ($tables as $table) {

            $requester->exec('Set FOREIGN_KEY_CHECKS = 0;');
            $failures = $checker->getFailuresOf($table);

            if (!empty($failures)) {

                foreach ($failures as $failure) {
                    fwrite(\STDOUT, sprintf(PHP_EOL . 'Removing %2$d row(s) from table %1$s', $table, \sizeof($failure->rowset)));
                    $query = sprintf('DELETE FROM %s WHERE 0 = 1', $table);
                    foreach ($failure->rowset as $row) {
                        $query .= ' OR ( 1 = 1 ';
                        foreach ($row as $col => $value) {
                            $query.= sprintf(' AND %1$s = %2$s'
                                    , $col
                                    , $requester->protect($value)
                            );
                        }
                        $query .= ')';
                    }
                    $requester->exec($query);

                    fwrite(\STDOUT, '...DONE' . PHP_EOL);
                }
            }
            $requester->exec('Set FOREIGN_KEY_CHECKS = 1;');
        }
        break;
    case 'list':
    default:

        foreach ($tables as $table) {
            $failures = $checker->getFailuresOf($table);
            foreach ($failures as $failure) {
                fwrite(\STDOUT, $failure->toString() . PHP_EOL);
            }
        }
        break;
}
fwrite(\STDOUT, PHP_EOL);




