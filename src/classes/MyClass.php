<?php
defined('APPROOT') or die('No direct script access.');

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
    function getTrue()
    {
        return true;
    }
}
