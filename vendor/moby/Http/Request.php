<?php

namespace Http;

use Http\InterfaceRequest;
use Validation\Validation;

/**
 * Class Request responsible for receipt parameters $_POST
 *
 * Contains validation functions
 * Return of $_POSTs 
 */	
class Request implements InterfaceRequest
{
    /**
     * Stores the errors what validation functions generate
     *
     * @var array
     */
    private $errors = [];
    
    /**
     * Stores the posts received for page
     *
     * @var array
     */
    private $post = [];
    
    /**
     * Stores the files received for page
     *
     * @var array
     */
    private $file = [];
    
    
    /**
     * Start the class storing the $_POST
     *
     * @return void
     */
    public function __construct()
    {
        $this->post = $_POST;
        $this->file = $_FILES;
            
        unset($_POST);
        unset($_FILES);
    }
    
    
    /**
     * Function responsible for retorns one input
     *
     * @param string $param(optional)
     * @return string OR array OR null
     */
    public function input($param = null)
    {
        if ($param)
            return $this->post[$param];
        
        return $this->post;
    }
    
    
    /**
     * Function responsible for return one input with validation
     *
     * @param string $param (Parameter of $_POST)
     * @param type_filter $restriction (Validation of input)
     * 
     * @return string OR BOOL(false)
     */
    public function filter_input($param, $restriction)
    {  
        /**
         * EXEMPLE VALIDATION:
         * 
         * FILTER_VALIDATE_URL
         * FILTER_VALIDATE_EMAIL
         * FILTER_VALIDATE_BOOLEAN
         * FILTER_VALIDATE_IP
         * FILTER_FLAG_NO_PRIV_RANGE 
         * FILTER_FLAG_ALLOW_OCTAL
         * FILTER_VALIDATE_INT
         * FILTER_SANITIZE_EMAIL
         */ 
        if (!filter_var($this->post[$param], $restriction))
            return false;
            
        return $this->post[$param];
    }
    
    
    /**
     * Funciton responsible for return one file
     *
     * @param string $param(optional)
     * @return array file OR file
     */
    public function file($key = null)
    {
        if (!$key)
            return $this;
    
        if (!isset($this->file[$key]) || !$this->file[$key])
            return false;
        
        $this->$key = $this->file[$key];

        return $this;
    }
    
    
    /**
     * Function responsible file validation and valid
     *
     * @return bool
     */
    public function isValid()
    {
        $validator   = true;
        $restriction = $this->files();
        
        var_dump($this->file);
        exit;
        
        foreach ($restriction as $key => $values) {
            $values = explode('|', $values);
                
            foreach ($values as $value) {
                if (!Validation::make($this->file, $value, $key))
                    $validator = false;
            }
        }
         
        return $validator;
    }
    
    
    /**
     * Returns the extension of file
     *
     * @return string
     */
    public function getExtension($fileName)
    {
        return pathinfo($fileName['name'], PATHINFO_EXTENSION);
    }
    
    
    /**
     * Function responsible for upload file
     *
     * @return string OR bool(false)
     */
    public function save()
    {
        if (!$this->file)
            return false;
            
        $response = [];
        
        foreach ($this->file as $file) {
            
            $uploadFile = rand(111111,999999) . '.' . $this->getExtension($file);
            
            $response[] = $uploadFile;
            
            if(!move_uploaded_file($file['tmp_name'], './public/uploads/' . $uploadFile))
                return false;
        }    
        
        return $response;
    }
    
    
    /**
     * Function responsible for get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return Validation::getErrors();
    }
    
    
    /**
     * Function responsible for start the form validation
     *
     * @return bool
     */
    public function run()
    {
        $validator = true;
        $rules = $this->rules();
        
        foreach ($rules as $key => $values) {
            $values = explode('|', $values);
            
            foreach ($values as $value)
                if (!Validation::make($this->post[$key], $value, $key))
                    $validator = false;
        }
        
        $this->clearAtributes();
        
        return $validator;
    }
    
    
    /**
     * Function responsible for reset class atributes
     *
     * @return void
     */
    private function clearAtributes()
    {
        $this->rules = [];
        $this->dados = [];
        // $this->errors = [];
    }
}