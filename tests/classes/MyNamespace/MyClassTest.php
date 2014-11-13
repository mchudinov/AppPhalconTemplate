<?php
namespace MyNamespace;

class MyClassTest extends \PHPUnit_Framework_TestCase 
{
    function test__constructor()
    {
        $obj = new \MyNamespace\MyClass();
        $this->assertNotNull($obj);
        $this->assertInstanceOf('\MyNamespace\MyClass', $obj);
    }
    
    function testgetTrue()
    {
        $obj = $this->getMock('\MyNamespace\MyClass', null);
        $this->assertFalse($obj->getFalse());
    }
}