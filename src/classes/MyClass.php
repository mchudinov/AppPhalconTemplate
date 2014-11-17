<?php
defined('APPROOT') or die('No direct script access.');

class MyClass
{
    function __construct()
    {
    }
    
	/**
     * @Log
     * @Cache
     */
    function getTrue()
    {
        return true;
    }
    
    /**
     * @LogDebug
     */
    function getFalse()
    {
        return false;
    }
}
