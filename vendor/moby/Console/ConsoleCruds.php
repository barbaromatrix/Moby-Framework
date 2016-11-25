<?php

namespace Console;

use Console\InterfaceConsole\Interfaces;
use Config\Connection;
/**
 * 
 */
class ConsoleCrud extends Connection implements InterfaceConsole
{
    /**
     * 
     */
    private static $arguments = [];
    
    
    /**
     * 
     */
    private static $descTable = [];
    
    
    /**
     * 
     */
    private static $ignoreLetter = [
        'tb_', 'tr_', 'tc_'
    ];
    
    
    /**
     * 
     */
    public static function run(array $arguments)
    {
        ConsoleCrud::$arguments = $arguments;
        
        $template = ConsoleCrud::getTemplate();
        
        if (!$conect = ConsoleCrud::getConection())
            return ConsoleCrud::getErrorComand(1);
        
        if (!$tables = ConsoleCrud::getTables($conect))
            return ConsoleCrud::getErrorComand(4);
        
        foreach ($tables as $table) {
            ConsoleCrud::setTable($table[0]);
            
            if (!$newTemplate = ConsoleCrud::openNewTemplate())
                return ConsoleCrud::getErrorComand(2);
            
            ConsoleCrud::getDescTable($conect);
            
            if (ConsoleCrud::writeTemplate($template, $newTemplate))
                return ConsoleCrud::getErrorComand(3);
            
            if (!fclose($newTemplate))
                return ConsoleCrud::getErrorComand(3);
                
            echo ConsoleCrud::getSuccessComand(2);
        }
        
        return ConsoleCrud::getSuccessComand(1);
    }
    
    
    /**
     * 
     */
    public static function getDescTable($conect)
    {
        $descTable = $conect->prepare("DESC " . ConsoleCrud::$arguments[2]);
        
        $descTable->execute();
        return ConsoleCrud::$descTable = $descTable->fetchAll();
    }
    
    
    /**
     * 
     */
    public static function setTable($table)
    {
        $ignore = ConsoleCrud::$ignoreLetter;
        
        ConsoleCrud::$arguments[2] = $table;
        ConsoleCrud::$arguments[3] = str_replace($ignore, '', strtolower($table));
        
        return;
    }
    
    
    /**
     * 
     */
    public static function getTables($conect)
    {
        $tables = $conect->prepare("SHOW TABLES");
        
        $tables->execute();
        return $tables->fetchAll();
    }
    
    
    /**
     * 
     */
    public static function openNewTemplate()
    {
        if (!ConsoleCrud::$arguments[3])
            return false;
            
        return fopen('App/Models/'.ucwords(strtolower(ConsoleCrud::$arguments[3])).'.php', 'w');
    }
    
    
    /**
     * 
     */
    public static function writeTemplate($template, $newTemplate)
    {
        $fields = "'";
        $primary_key = '';
        
        foreach (ConsoleCrud::$descTable as $field) {
            if ($field[3] == 'PRI')
                $primary_key = $field[0];
            else
                $fields .= $field[0]."', '";
        }
        
        $template = str_replace('[#class#]', ucwords(strtolower(ConsoleCrud::$arguments[3])), $template);
        $template = str_replace('[#table#]', ConsoleCrud::$arguments[2], $template);
        $template = str_replace('[#primary_key#]', $primary_key, $template);
        $template = str_replace('[#fields#]', substr($fields, 0, -3), $template);
        
        fwrite($newTemplate, $template);
    }
    
    
    /**
     * 
     */
    public static function getConection()
    {
        return parent::connect();
    }
    
    
    /**
     * 
     */
    public static function getSuccessComand($code = 1)
    {
        switch ($code) {
            case '1':
                return "---------------------------------------------- \n \n \n"
                    ."Moby Framework \n \n"
                    ."All Models successfully Consoled \n";
                break;
            
            case '2':
                return "Model " . ConsoleCrud::$arguments[2] . " successfully Consoled \n \n";
                break;
            
            default:
                return " ---------------------------- \n \n \n"
                    ." Moby Framework "
                    ."All Models successfully Consoled";
                break;
        }
        
    }
    
    
    /**
     * 
     */
    public static function getErrorComand($controlNamberError = 1)
    {
        switch ($controlNamberError) {
            case '1':
                return "Database error: \n"
                        ."Check the connection data \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '2':
                return "Comand error: $ php moby Console:models \n"
                        ."Try $ php moby Console:models --database \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '3':
                return "Internal server error: \n"
                        ."Try again \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '4':
                return "Database error: \n"
                        ."No tables \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
        }
        
    }
    
    
    /**
     * 
     */
    public static function getTemplate()
    {
        return file_get_contents('vendor/moby/Console/Templates/ModelsTemplate.php');
    }
}