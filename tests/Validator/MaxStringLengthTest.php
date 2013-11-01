<?php
use Vision\Validator;

class MaxStringLengthTest extends \PHPUnit_Framework_TestCase
{
    static $validatorOne;

    protected $singleBytes = array('$', '$$');
    
    protected $multiBytes = array('¢', '€', '¢¢', '€€');
    
    public static function setUpBeforeClass()
    {
        self::$validatorOne = new Validator\MaxStringLength(1);
    }
    
    public function testGetMax()
    {       
        $this->assertSame(1, self::$validatorOne->getMax());
    }
    
    public function testCastToInteger()
    {
        $validator = new Validator\MaxStringLength('1');
        
        $this->assertSame(1, $validator->getMax());
    }
    
    public function testSingleByteSuccess()
    {
        $this->assertTrue(self::$validatorOne->isValid($this->singleBytes[0]));
    }
    
    public function testSingleByteFailure()
    {
        $this->assertFalse(self::$validatorOne->isValid($this->singleBytes[1]));
    }
    
    public function testMultiByteSuccess()
    {
        $this->assertTrue(self::$validatorOne->isValid($this->multiBytes[0]));
        $this->assertTrue(self::$validatorOne->isValid($this->multiBytes[1]));
    }
    
    public function testMultiByteFailure()
    {
        $this->assertFalse(self::$validatorOne->isValid($this->multiBytes[2]));
        $this->assertFalse(self::$validatorOne->isValid($this->multiBytes[3]));
    }   
}