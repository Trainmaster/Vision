<?php
use Vision\Validator;

class IntegerTest extends \PHPUnit_Framework_TestCase
{
    static $validator;
    
    public static function setUpBeforeClass()
    {
        self::$validator = new Validator\Integer;
    }
    
    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid(-1));
        $this->assertTrue(self::$validator->isValid(-0));
        $this->assertTrue(self::$validator->isValid(0));
        $this->assertTrue(self::$validator->isValid(+0));
        $this->assertTrue(self::$validator->isValid(1));
    }
    
    public function testFailure()
    {        
        $this->assertFalse(self::$validator->isValid(new stdClass));
        $this->assertFalse(self::$validator->isValid(false));
        $this->assertFalse(self::$validator->isValid(null));
        $this->assertFalse(self::$validator->isValid(0.1));
        $this->assertFalse(self::$validator->isValid(''));
        $this->assertFalse(self::$validator->isValid(array()));      
    } 
}