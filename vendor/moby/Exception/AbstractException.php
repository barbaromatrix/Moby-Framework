<?php

namespace Exception;

use Exception;
use Exception\InterfaceException;

abstract class AbstractException extends Exception
{
    /**
     * 
     * 
     */ 
    public function render($view, $args = [])
    {
        try {
            if (!file_exists(__DIR__ . '/../../../App/Views/errors/' . $view . '.php'))
                throw new Exception();
            
            return include(__DIR__ . '/../../../App/Views/errors/' . $view . '.php');
            
        } catch (Exception $e) {
            return include(__DIR__ . '/../../../App/Views/errors/default-error.php');
        }
    }
}