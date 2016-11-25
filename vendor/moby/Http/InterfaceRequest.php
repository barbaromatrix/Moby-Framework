<?php

namespace Http;

/**
 * undocumented class
 *
 * @package default
 * @author `g:snips_author`
 */
interface InterfaceRequest
{
    public function __construct();
    
    public function input($param = null);
    
    public function filter_input($param, $restriction);
    
    public function file($param = null);
    
    public function isValid();
    
    public function getExtension($fileName);
    
    public function save();
    
    public function getErrors();
    
    public function run();
}