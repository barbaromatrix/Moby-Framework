<?php

namespace App\Exception;

use Exception\ViewException;

/**
 * 
 */
class ConfigException extends ViewException
{
    /**
     * 
     */
    public function routeNotFound()
    {
        // return view('route-not-found');
    }
    
    
    /**
     * 
     */
    public function maintenanceWebsite()
    {
        // return view('maintenance-website');
    }
    
    
    /**
     * 
     */
    public function routeNotAccess()
    {
        // return view('route-not-access');
    }
}