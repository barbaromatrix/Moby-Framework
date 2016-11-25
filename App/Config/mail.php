<?php

namespace App\Config;

/*
| -------------------------------------------------------------------
|  Server email configuration
| -------------------------------------------------------------------
|
|  $host => Corresponds to host of email server
|  
|  $SMTPAuth => Corresponds if should true autentication for access 
|               email server.
|  
|  $Username => Corresponds to user of email server
|  
|  $Password => Corresponds to passworld of email server
|  
|  $SMTPSecure => Corresponds to cryptography of email server
|  
|  $Port => Corresponds to door communication of email server
|  
*/
$Host       = '';
$SMTPAuth   = true;
$Username   = '';
$Password   = '';
$SMTPSecure = 'tls';
$Port       = '587';