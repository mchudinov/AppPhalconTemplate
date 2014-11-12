<?php
require "phpunitbootstrap.php";                                             

defined('APPPATH') or die('No direct script access.');
                                      
class TestRunner
{
    private static $_suiteUnit;
    
    public static function suiteUnit()
    {
        self::$_suiteUnit = new PHPUnit_Framework_TestSuite();
        self::$_suiteUnit->addTestSuite("\MyClassTest");
        return self::$_suiteUnit;
    }
}  

$suiteUnit = \TestRunner::suiteUnit();
PHPUnit_TextUI_TestRunner::run($suiteUnit);
