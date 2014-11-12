<?php
class MyClassTest extends \PHPUnit_Framework_TestCase 
{
    function test__constructor()
    {
        $obj = new MyClass();
        $this->assertNotNull($obj);
        $this->assertInstanceOf('\MyClass', $obj);
    }
    
    function testgetTrue()
    {
        $obj = $this->getMock('\MyClass', null);
        $this->assertTrue($obj->getTrue());
    }
}