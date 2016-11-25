<?php

namespace Validation;

/**
 * Class responsible for validation 
 */
class Validation
{
    /**
     * Stores the errors what validation functions generate
     *
     * @var array
     */
    private static $errors = [];
    
    
    /**
     * Stores the rules of validation
     *
     * @var array
     */
    private static $rules = [];
    
    
    /**
     * Stores the restriction of validation
     *
     * @var array
     */
    private static $restriction = [];
    
    
    /**
     * Instance this class
     *
     * @var object this
     */
    private static $instance = false;
    
    
    /**
     * 
     *
     * @return 
     */
    public static function rules(array $input, array $rules)
    {
        if (!static::$instance)
            $instance = new Validation();
        else
            $instance = static::$instance;
        
        static::$rules = $input;
        static::$restriction = $rules;
    }
    
    
    /**
     * Function responsible for start the form validation
     *
     * @return bool
     */
    public static function run()
    {
        $validator = true;
        
        $rules       = static::$rules;
        $restriction = static::$restriction;
        
        foreach ($restriction as $key => $values) {
            $values = explode('|', $values);
            
            foreach ($values as $value)
                if (!Validation::make($rules[$key], $value, $key))
                    $validator = false;
        }
        
        Validation::clearAtributes();
        
        return $validator;
    }
    
    
    /**
     * Funciton responsible for validation each field
     *
     * @param string $key (position post)
     * @param string $restriction (restrinction validation)
     * 
     * @return bool
     */
    public static function make($param, $restriction, $key = false)
    {
        if (!static::$instance)
            $instance = new Validation();
        else
            $instance = static::$instance;
        
        $response = true;
        
        // Verify if existis the caracter '[' for validations (max_length, min_length, is_unique, in_list)
        if (strpos($restriction, '[')) {
            $restriction_explode = explode('[', $restriction);
            
            $min_max_unique_inList_extension_maxsize = str_replace(']', '', $restriction_explode[1]);
            $restriction = $restriction_explode[0];
        }
        
        // Search what validation must be applied for that rule
        switch ($restriction) {
            case 'required':
                if (!$param) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' is required';
                }
                break;
                
            case 'unique':
                // code
                break;
                
            case 'max':
                if (strlen($param) > $min_max_unique_inList_extension_maxsize) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must be smaller what ' . $min_max_unique_inList_extension_maxsize;
                }
                break;
                
            case 'min':
                if (strlen($param) < $min_max_unique_inList_extension_maxsize) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must be large what ' . $min_max_unique_inList_extension_maxsize;
                }
                break;
                
            case 'list':
                $in_list = explode(',', $min_max_unique_inList_extension_maxsize);
                $compare_in_list = false;
                $list = '';
                
                foreach ($in_list as $il) {
                    if ($param == $il)
                        $compare_in_list = true;
                    
                    $list .= $il . ', ';
                }
                
                if (!$compare_in_list) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must be presents in list ' . substr($list, 0, -2);
                } 
                break;
                
            case 'int':
                if (!preg_match('/^[0-9]+$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must to contain only numbers';
                }
                break;
                
            case 'alpha':
                if (!preg_match('/^[a-zA-Z]+$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter only letters';
                }
                break;
                
            case 'email':
                if (!preg_match('/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid email';
                }
                break;
                
            case 'url':
                if (!filter_var($param, FILTER_VALIDATE_URL)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid URL';
                }
                break;
                
            case 'cep':
                if (!preg_match('/^\d{8}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid CEP. Ex: 99999999';
                }
                break;
                
            case 'cep_point':
                if (!preg_match('/^\d{5}-\d{3}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one CEP válido. Ex: 99999-999';
                }
                break;
                
            case 'tel':
                if (!preg_match('/^\d{4}-\d{4}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid telephone. Ex: 9999-9999';
                }
                break;
                
            case 'tel_ddd':
                if (!preg_match('/^\(\d{2}\)[\s-]?\d{4}-\d{4}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one telephone with valid DDD. Ex: (99)9999-9999';
                }
                break;
                
            case 'cell_phone_no_ddd':
                if (!preg_match('/^\d{5}-\d{4}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid cell phone. Ex: 99999-9999';
                }
                break;
                
            case 'cell_phone':
                if (!preg_match('/^\(\d{2}\)[\s-]?\d{5}-\d{4}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid cell phone with valid DDD. Ex: (99)99999-9999';
                }
                break;
                
            case 'cpf':
                if (!preg_match('/^[0-9]{11}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid CPF. Ex: 99999999999';
                }
                break;
                
            case 'cpf_point':
                if (!preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2,2}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid CPF. Ex: 999.999.999-99';
                }
                break;
                
            case 'cnpj_point':
                if (!preg_match('/^\d{3}.\d{3}.\d{3}/\d{4}-\d{2}$/', $param)) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must conter one valid CNPJ. Ex: 999.999.999/9999-99';
                }
                break;
                
            case 'extension':
                $extensions = explode(',', $min_max_unique_inList_extension_maxsize);
                $compare_extension = false;
                $list = '';
                
                $extension_file_type = pathinfo($param['name'], PATHINFO_EXTENSION);
                
                foreach ($extensions as $extension) {
                    if ($extension_file_type == $extension)
                        $compare_extension = true;
                    
                    $list .= $extension . ', ';
                }
                
                if (!$compare_extension) {
                    $response = false;
                    static::$errors[] = 'The field ' . $key . ' must be present in list: ' . substr($list, 0, -2);
                } 
                break;
            
            case 'max_size':
                if ($param['size'] > (str_replace('MB', '', $min_max_unique_inList_extension_maxsize) * 1000000))
                    $response = false;
                
                break;
        }
        
        return $response;
    }
    
    
    /**
     * Funciton responsible for reset class atributes
     *
     * @return void
     */
    public static function clearAtributes()
    {
        static::$rules       = [];
        static::$restriction = [];
    }
    
    
    /**
     * Funciton responsible for returns errors of array
     *
     * @return array
     */
    public static function getErrors()
    {
        return static::$errors;
    }
}