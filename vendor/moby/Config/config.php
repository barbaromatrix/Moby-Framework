<?php

namespace Config;

/*
| -------------------------------------------------------------------
|  Global variables
| -------------------------------------------------------------------
|
|  Declaration of global application variables
|
*/
global $host, $user, $pass, $charset, $database, $dns, $baseurl;

/*
| -------------------------------------------------------------------
|  Seting value global variables
| -------------------------------------------------------------------
|
|  Sets the value defined in the application config for global 
|  variables
|
*/
$GLOBALS['baseurl']     = $baseurl;
$GLOBALS['localhost']   = $localhost;

$GLOBALS['host']        = $database[$database_use]['host'];
$GLOBALS['user']        = $database[$database_use]['user'];
$GLOBALS['pass']        = $database[$database_use]['pass'];
$GLOBALS['charset']     = $database[$database_use]['charset'];
$GLOBALS['dns']         = $database[$database_use]['dns'];
$GLOBALS['database']    = $database[$database_use]['database'];