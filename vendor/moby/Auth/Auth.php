<?php

namespace Auth;

use Session\Session;
use Auth\Interfaces\InterfaceAuth;
use Auth\Exception\AuthException;
/**
 * 
 */
class Auth implements InterfaceAuth
{
    /**
     * 
     */
    private $_users = [];
    
    
    /**
     * 
     */
    public function auth()
    {
        $this->_users = $this->users();
    }
    
    
    /**
     * 
     */
    public function hasAuth($user)
    {
        $this->auth();
        
        foreach ($this->_users as $u) {
            if ($u['name'] == $user && Session::has($user))
                return true;
        }

        return false;
    }
    
    
    /**
     * 
     */
    public function redirecAuth($user)
    {
        $this->auth();
        
        foreach ($this->_users as $u) {
            if ($u['name'] == $user)
                return $u['redirect'];
        }


        return '/';
    }
}