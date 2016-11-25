<?php

namespace App\Config;


/*
| -------------------------------------------------------------------
|  Caracter of application
| -------------------------------------------------------------------
|
|  By default, the application has the caracter UTF-8
|
*/
$_display_errors = true;

/*
| -------------------------------------------------------------------
|  Caracter of application
| -------------------------------------------------------------------
|
|  By default, the application has the caracter UTF-8
|
*/
header('Content-Type: text/html; charset=utf-8');

/*
| -------------------------------------------------------------------
|  Base URL
| -------------------------------------------------------------------
|
|  The $baseurl is the URL required for arrive to index.php (in root 
|  of application).
|
| -------------------------------------------------------------------
|  Exemple 1: 
|
|  If the URL be that for arrive to index.php
|       http://localhost/index.php
|     or
|       http://localhost
|
|   Then $baseurl will be
|       http://localhost/
| 
| -------------------------------------------------------------------
|  Exemple 2: 
|
|  URL of a website hosped
|       http://mobyframework.com/index.php
|     or
|       http://mobyframework.com
|
|   Then $baseurl will be the same
|       http://mobyframework.com/
|
| -------------------------------------------------------------------
|
| Obs: Never leave the index.php in $baseurl, because the file .htaccess 
|      of application ignore this.
| 
*/
$baseurl = '';
$localhost = false;

/*
| -------------------------------------------------------------------
|  Datetime
| -------------------------------------------------------------------
|
|  Data default in São Paulo
|
*/
date_default_timezone_set('America/Sao_Paulo');