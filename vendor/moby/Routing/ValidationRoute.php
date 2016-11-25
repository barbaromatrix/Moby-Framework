<?php

namespace Routing;

use Routing\Route;
use Validation\Validation;

/**
 * Class responsible for URL and route validation
 */
class ValidationRoute
{
    /**
     * Verify if the environment is localhost and retrieve the parameters of URL
     * 
     * @return string
     */
    public function hasLocalhost()
    {
        $uri = $_SERVER['REQUEST_URI'];

        if ($GLOBALS['localhost']) {
            if (substr($uri, 0, 4) != 'http')
                $uri = $_SERVER['HTTP_HOST'] . $uri;

            $uri = 'http://'.$uri;
            
            if (substr($uri, -1, 1) == '/')
                $uri = substr($uri, 0, -1);

            if ($GLOBALS['baseurl']) {
                if (substr($GLOBALS['baseurl'], -1, 1) == '/')
                    $GLOBALS['baseurl'] = substr($GLOBALS['baseurl'], 0, -1);

                $uri = str_replace($GLOBALS['baseurl'], '', $uri);
            }
                
            if (!$uri)
                $uri = '/';
        }

        return $uri;
    }
    
    
    /**
     * Verify if the route it's inside in group and format the route/url
     * 
     * @return void
     */
    public function hasGroup($group, $route)
    {
        if (Route::$_group)
            Route::$_route = Route::$_group . Route::$_route;
        
        if ($group) {
            if (Route::$_group) {
                Route::$_group .= $route;
                Route::$_url = substr(Route::$_url, 0, strlen(Route::$_group));
            } else {
                Route::$_group = $route;
                Route::$_url = substr(Route::$_url, 0, strlen(Route::$_route));
            }
        }
    }
    
    
    /**
     * Verify if has parameters in route and format the route/url
     * 
     * @return void
     */
    public function hasparam($route, $uri)
    {
        if (!strripos($route, '{'))
            return false;
        
        Route::$_route       = explode('/{', Route::$_route)[0];
        Route::$_param_route = explode(',', str_replace('}', '', explode('{', $route)[1]));
        Route::$_url         = explode('/', Route::$_url);
        
        foreach (Route::$_param_route as $value) {
            if (substr($value, -1) != '?') {
                Route::$_param_url[] = end(Route::$_url);
                array_pop(Route::$_url);
                Route::$_param_url = array_reverse(Route::$_param_url);
            } else
                Route::$_optional_param += 1;
        }
        
        $_optional_param = Route::$_optional_param;
        $optional_param_array = 0;
        
        while ($_optional_param) {
            if (implode('/', Route::$_url) != Route::$_route) {
                Route::$_param_url[] = end(Route::$_url);
                array_pop(Route::$_url);
            } else
                $optional_param_array += 1;

            $_optional_param -= 1;
        }
        
        Route::$_param_url = array_reverse(Route::$_param_url);
        
        for ($i = 0; $i < $optional_param_array; $i++)
            Route::$_param_url[] = false;
            
        Route::$_url = implode('/', Route::$_url);
    }
    
    
    /**
     * Verify if has where and where clause is valid 
     * 
     * @return bool
     */ 
    public function hasWhere()
    {
        if (!Route::$_where)
            return true;
            
        if (!Route::$_param_route)
            return true;
        
        if (!Route::$_valid_param_url)
            return true;
        
        foreach (Route::$_param_route as $key => $value) {
            if (isset(Route::$_where[$value]) && Route::$_where[$value] && isset(Route::$_valid_param_url[$key]) && Route::$_valid_param_url[$key]) {
                $conditions = explode('|', Route::$_where[$value]);
                
                foreach ($conditions as $condition) {
                    if (!Validation::make(Route::$_valid_param_url[$key], $condition))
                        return false;
                }
            }
        }
        
        return true;
    }
    
    
    /**
     * Verify if should treat the caracters uppercase and lowercase
     * 
     * @return void
     */
    public function hasUppercase()
    {
        if (!Route::$uppercase) {
            Route::$_route = strtolower(Route::$_route);
            Route::$_url   = strtolower(Route::$_url);
        }
    }
    
    
    /**
     * Verify if the URL equals the route
     * 
     * @return bool
     */
    public function isURL($route, $uri)
    {
        if (Route::$_route === Route::$_url && count(Route::$_param_url) === count(Route::$_param_route))
            return true;
        
        ValidationRoute::clearparams($route);
        
        return false;
    }
    
    
    /**
     * Clear all params of Route class
     * 
     * @paran string $route
     * @return void
     */ 
    public function clearparams($route = false)
    {
        Route::$_optional_param  = 0;
        Route::$_url             = null;
        Route::$_route           = null;
        Route::$_param_url       = [];
        Route::$_param_route     = [];
        Route::$_where           = [];
        
        if ($route)
            Route::$_group = str_replace($route, '', Route::$_group);
    }
}