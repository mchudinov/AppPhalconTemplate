<?php
namespace MyNamespace;

defined('APPPATH') or die('No direct script access.');

  /**
 * ��� �����������
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
