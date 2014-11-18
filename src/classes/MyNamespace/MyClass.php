<?php
namespace MyNamespace;

defined('APPROOT') or die('No direct access.');

class MyClass
{
    function __construct()
    {
    }
    
	/**
     * @Log
     */
    function getFalse()
    {
        return false;
    }
}
