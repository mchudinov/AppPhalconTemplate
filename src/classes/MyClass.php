<?php
defined('APPPATH') or die('No direct script access.');

class MyClass
{
    function __construct()
    {
    }
    
    function getTrue()
    {
        return true;
    }
    
    private function getTrue234()
    {
        eval("echo'';");
        goto a;
        echo 'Foo';
         
        a:
        echo 'Bar';
        return true;
    }
}
