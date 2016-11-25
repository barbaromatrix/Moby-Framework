<?php

/**
 * Default route
 */ 
    $app->get('/', function(){
        return view('welcome');
    });