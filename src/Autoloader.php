<?php
defined('APPPATH') or die('No direct script access.');

/**
 * @codeCoverageIgnore
 */
class Autoloader
{
    public static function Register() 
    {
        return spl_autoload_register(array('Autoloader', 'Load'));
    }


    public static function Load($strClassName)
    {
        $strFilePath = APPPATH.'src/classes/'.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        $strFilePath = APPPATH.'src'.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        $strFilePath = APPPATH.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }        
        
        $strFilePath = APPPATH.'tests/classes/'.$strClassName.'.php';
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        $strFilePath = APPPATH.'tests/'.$strClassName.'.php'; 
        if (file_exists($strFilePath)) 
        {
            require_once($strFilePath);
            return true;
        }
        
        return false;
    }
}

Autoloader::Register();