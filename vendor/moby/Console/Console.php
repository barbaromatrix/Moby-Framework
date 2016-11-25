<?php

namespace Console;

/**
 * 
 */
class Console
{
    /**
     * 
     */
    private $arguments = [];
    
    
    /**
     * 
     */
    private $comands = [
        '', 'help', 'make:model', 'make:controller', 'make:models', 
        'make:request', 'make:crud', 'make:cruds',
    ];
    
    
    /**
     * 
     */
    public function __construct($arguments)
    {
        $this->arguments = $arguments;
    }
    
    
    /**
     * 
     */
    public function run()
    {
        if (!isset($this->arguments[1]))
            return $this->getDescrition();
            
        if (!$this->validationComand())
            return $this->getErrorComand();
        
        if (!$status = $this->executeComand())
            return $this->getErrorComand();
            
        return $status . " \n";
    }
    
    
    /**
     * 
     */
    private function validationComand()
    {
        foreach ($this->comands as $comand) {
            if (isset($this->arguments[1]) || $this->arguments[1] == $comand)
                if ($this->arguments[1] != 'make:models')
                    return true;
                
                if (isset($this->arguments[2]) && $this->arguments[2] == '--database')
                    return true;
        }
        
        return false;
    }
    
    
    /**
     * 
     */
    private function executeComand()
    {
        if ($this->arguments[1] == 'help')
            return $this->getDescrition(2);
        
        $comandExplode = explode(':', $this->arguments[1]);
        $class = 'Console\\Console'.ucwords($comandExplode[1]);
        
        return $class::run($this->arguments);
    }
    
    
    /**
     * 
     */
    private function getErrorComand()
    {
        $comand = $this->arguments[0] . ' ' . $this->arguments[1];
        
        return "Comand: '$ php $comand' not found \n \n"
                ."Need help? \n"
                ."$ php moby help \n";
    }
    
    
    /**
     * 
     */
    private function getDescrition($code = 1)
    {
        switch ($code) {
            case '1':
                return "Moby Framework  version 1.0 \n \n"
                    ."http://mobyframework.com \n"
                    ."Creator: Vinicius Pugliesi \n"
                    ."Website: http://viniciuspugliesi.com \n"
                    ."Github: viniciuspugliesi \n";
                break;
                
            case '2':
                return "| ------------------------------------------------------------------- \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."|   Console of Moby Framework \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."|  \n"
                    ."|   \n"
                    ."|   Available commands: \n"
                    ."| ------------------------------------------------------------------- \n"
                    ."| \n"
                    ."|   $ php moby \n"
                    ."|       (Show information of Moby Framework) \n"
                    ."| \n"
                    ."|   $ php moby help \n"
                    ."|       (Show the avaliable commands for use) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:request {request-name} \n"
                    ."|       (Create one new Request) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:controller {controller-name} \n"
                    ."|       (Create one new Controller) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:model {model-name} \n"
                    ."|       (Create one new Model) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:model --database {table-name} \n"
                    ."|       (Create one new Model by table name) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:models --database \n"
                    ."|       (Create all Models according the database) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:crud --database {table-name} \n"
                    ."|       (Create new Crud by table name) \n"
                    ."| \n"
                    ."| \n"
                    ."|   $ php moby make:cruds --database \n"
                    ."|       (Create all Cruds according the database) \n"
                    ."| ------------------------------------------------------------------- \n";
                break;
        }
    }
}