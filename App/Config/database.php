<?php

namespace App\Config;

/*
| -------------------------------------------------------------------
|  File configuration of database
| -------------------------------------------------------------------
|
|  With the array $database, you can place all connections with database
|
|  With the variable $databaseUse you speat what database should be used default for connection
|
*/
$database_use = 'default';
 

$database['default'] = [
    'host'      => 'localhost',
    'user'      => '',
    'pass'      => '',
    'database'  => '',
    'charset'   => 'utf8',
    'dns'       => 'mysql' // My SQL
];
    
$database['sqlserver'] = [
    'host'      => 'localhost',
    'user'      => '',
    'pass'      => '',
    'database'  => '',
    'charset'   => 'utf8',
    'dns'       => 'sqlserver' // SQL SERVER
];
    
$database['oracle'] = [
    'host'      => 'localhost',
    'user'      => '',
    'pass'      => '',
    'database'  => '',
    'charset'   => 'utf8',
    'dns'       => 'oracle' // oracle
];