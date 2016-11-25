<?php

/*
| -------------------------------------------------------------------
|  Autoload of application
| -------------------------------------------------------------------
|
|  Starting the autoload of application
|  Autoload pattern of PSR-4
|
*/
require_once __DIR__ . '/../vendor/autoload.php';


/*
| -------------------------------------------------------------------
|  Config of application
| -------------------------------------------------------------------
|
|  Starting the basic configurations of system
|  
|  Database
|  Server email
|  Format date and time
|  
*/
require_once __DIR__ . '/../App/Config/config.php';
require_once __DIR__ . '/../App/Config/database.php';
require_once __DIR__ . '/../App/Config/mail.php';


/*
| -------------------------------------------------------------------
|  Config of vendor
| -------------------------------------------------------------------
|
|  Starting the basic configurations of system in vendor
|  
*/
require_once __DIR__ . '/../vendor/moby/Config/config.php';

$status = new Console\Console($argv);

return $status->run();