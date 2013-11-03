<?php
use Vision\Validator\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    static $validator;
    
    public static function setUpBeforeClass()
    {
        self::$validator = new Email;
    }
    
    public function testSuccess()
    {
        $this->assertTrue(self::$validator->isValid('foo@bar.com'));        
    }
    
    public function testFailure()
    {        
        $this->assertFalse(self::$validator->isValid(''));
    }
}