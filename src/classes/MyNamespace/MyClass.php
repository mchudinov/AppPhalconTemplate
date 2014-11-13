<?php
namespace MyNamespace;

defined('APPPATH') or die('No direct script access.');

  /**
 * Это комментарий
 *
 * @Cache(key="my-key", lifetime=86400)
 */
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
