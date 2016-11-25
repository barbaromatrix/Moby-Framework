<?php

namespace Routing;

use Routing\System;
use Routing\ValidationRoute;
use Routing\Exception\RouteException;

/**
 * Class of application routes (GET, POST, PUT, DELETE)
 *
 */
class Route extends ValidationRoute
{
    /**
     * Considered or not characters capitalized route or URL
     *
     * @var bool
     */
	public static $uppercase = true;
    
    
    /**
     * Navigatior URL 
     *
     * @var string
     */
	protected static $_url;
    
    /**
     * Route pass URL for application
     *
     * @var string
     */
	protected static $_route;
    
    /**
     * Method for call
     *
     * @var string
     */
	protected static $_call;
    
    /**
     * Method for valid call
     *
     * @var array
     */
    protected static $_valid_call;
    
    /**
     * Routes group
     *
     * @var string
     */
	protected static $_group;
    
    /**
     * Parameters of route pass for the application
     *
     * @var string
     */
	protected static $_param_route;
    
    /**
     * Where clause of route pass for the application
     *
     * @var where
     */
	protected static $_where = [];
    
    /**
     * Parameters of url of navigator
     *
     * @var array
     */
	protected static $_param_url = [];
    
    /**
     * Parameters valid of url of navigator
     *
     * @var array
     */
    protected static $_valid_param_url = [];
    
    /**
     * Parameters optionals in URL
     *
     * @var int
     */
    protected static $_optional_param = 0;
    
    /**
     * Function that receive all types requests
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $this
     */
	public function any($route, $call)
    {
        if (!Route::validar_url($route, $call))
            return $this;
         
        if (is_object($call)) {
            Route::$_valid_call = $call;
            Route::$_valid_param_url = Route::$_param_url;
        } else {
            Route::$_valid_call = explode(':', $call);
            Route::$_valid_param_url = Route::$_param_url;
        }
        
        return $this;
    }
    
    
    
    /**
     * Function that receive request type GET
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $this
     */
	public function get($route, $call)
    {
        if (!Route::validar_url($route, $call))
            return $this;
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            if (is_object($call)) {
                Route::$_valid_call = $call;
                Route::$_valid_param_url = Route::$_param_url;
            } else {
                Route::$_valid_call = explode(':', $call);
                Route::$_valid_param_url = Route::$_param_url;
            }
            
            return $this;
        }
    }
    
    
    
    /**
     * Function that receive request type POST
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $this
     */
	public function post($route, $call)
    {
        if (!Route::validar_url($route, $call))
            return $this;
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            return $this;
            
        Route::$_valid_param_url = Route::$_param_url;
            
        if (is_object($call))
            Route::$_valid_call = $call;
        else
            Route::$_valid_call = explode(':', $call);
            
        return $this;
    }
    
    
    
    /**
     * Function that receive request type PUT
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $this
     */
	public function put($route, $call)
    {
        if (!Route::validar_url($route, $call))
            return $this;
            
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT')
            return $this;
        
        Route::$_valid_param_url = Route::$_param_url;    
        
        if (is_object($call))
            Route::$_valid_call = $call;
        else
            Route::$_valid_call = explode(':', $call);
            
        return $this;
    }
    
    
    
    /**
     * Function that receive request type DELETE
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $this
     */
	public function delete($route, $call)
    {
        if (!Route::validar_url($route, $call))
            return $this;
            
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE')
            return $this;
            
        Route::$_valid_param_url = Route::$_param_url;
        
        if (is_object($call))
            Route::$_valid_call = $call;
        else
            Route::$_valid_call = explode(':', $call);
            
        return $this;
        
    }
    
    
    
    /**
     * Function that group the routes
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $call()
     */
	public function group($route, $call)
    {
        if (!Route::validar_url($route, $call, true))
            return $this;
            
        if (!is_object($call))
            return $this;

        return $call();
    }
    
    
    
    /**
     * Function that authenticates the routes
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return $call()
     */
	public function middleware($auth, $call = false)
    {
        var_dump($auth);
        var_dump($call);
        // $call();
        
        // if (!Route::hasAuth($auth))
        //     return redirect(Route::redirecAuth($auth));
            
        // if (!is_object($call))
        //     return $this;
    }
    
    
    
    /**
     * Function that name the route
     *
     * @param string $name
     * @return void
     */
	public function name($name)
    {
    }
    
    
    
    /**
     * Function that where the route
     *
     * @param array $where
     * @return void
     */
	public function where(array $where)
    {
        Route::$_where = $where;
        
        if (!ValidationRoute::hasWhere() && Route::$_route === Route::$_url && count(Route::$_param_url) === count(Route::$_param_route)) {
            ValidationRoute::clearparams();
            
            Route::$_valid_param_url = [];
            Route::$_valid_call      = '';
        }
        
        return $this;
    }
    
    
    
    /**
     * Function that valid if the route is the same as the url of navigator
     *
     * @param string $route (route)
     * @param string $call (method)
     * 
     * @return true or $this
     */
	private function validar_url($route, $call, $group = false)
    {
        $uri = ValidationRoute::hasLocalhost();
        
        Route::$_url = $uri;
        Route::$_route = $route;
        
        ValidationRoute::hasGroup($group, $route);
        ValidationRoute::hasparam($route, $uri);
        ValidationRoute::hasUppercase();
        
        if (!ValidationRoute::isURL($route, $uri))
            return false;
        
        return true;
    }
    
    
    
    /**
     * Function runs the route
     *
     * 
     * @return new instance controller
     */
    public function run()
    {
        try {
            if (!Route::$_valid_call)
                throw new RouteException('Route not found', 40);
            
            $call = Route::$_valid_call;
            
            if (is_object($call))
                return call_user_func_array($call, Route::$_valid_param_url);
            
            return System::run(Route::$_valid_call, Route::$_valid_param_url);
            
        } catch (RouteException $e) {
            $e->render('default-error', $e);
        }
    }
}