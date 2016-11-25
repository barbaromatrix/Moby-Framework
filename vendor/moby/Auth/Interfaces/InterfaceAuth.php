<?php

namespace Auth\Interfaces;

/**
 * undocumented class
 *
 * @package default
 * @author `g:snips_author`
 */
interface InterfaceAuth
{
    public function auth();
    
    public function hasAuth($user);
    
    public function redirecAuth($user);
}