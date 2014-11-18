<?php
defined('APPROOT') or die('No direct access.');

class MyClass
{
    function __construct()
    {
    }
    
	/**
     * @Log
     * @Cache */
    function getTrue()
    {
        return true;
    }
    
    /** @LogDebug */
    function getFalse()
    {
        return false;
    }
}
