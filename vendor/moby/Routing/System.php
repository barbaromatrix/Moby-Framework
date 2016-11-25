<?php

namespace Routing;

use App\Http\Middleware\Auth;
use App\Http\Requests\Request;
use Routing\Exception\SystemException;

/**
 * Class responsible for instantiates the controller that the route to pass
 *
 */
class System extends Auth
{
    /**
     * Function responsible for instantiate the controller
     *
     * @var array $url ([0] => 'Controller', [1] => 'method')
     * @var array $param (parameters for pass to $_GET)
     * 
     * @return void 
     */
	public static function run($url = [], $param = [])
	{
		$controller	= $url[0];
		$action		= $url[1];
		
		$controller = 'App\Http\\Controllers\\'.$controller.'Controller';
		
		try {
			if (!class_exists($controller))
				throw new SystemException('Class does not exists', 30);
			
			array_unshift($param, new Request());
			$controller = new $controller();
			
			if (!method_exists($controller, $action))
				throw new SystemException('Method does not exists', 20);
			
			call_user_func_array([$controller, $action], $param);
			
		} catch (SystemException $e) {
			$e->render('default-error', $e);
		}
	}
}