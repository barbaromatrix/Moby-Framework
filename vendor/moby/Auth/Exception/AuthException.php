<?php

namespace Auth\Exception;

use \Exception;
use InterfaceException\InterfaceException;

/**
 * 
 */
class ExceptionAuth extends Exception implements InterfaceException
{   
    /**
     * 
     */
    public function render()
    {
        echo $this->getMessage();
    }
}