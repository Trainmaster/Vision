<?php
use Vision\Validator;

class MinStringLengthTest extends \PHPUnit_Framework_TestCase
{
    static $validatorOne;
    
    static $validatorTwo;
    
    protected $singleBytes = array('$');
    
    protected $multiBytes = array('¢', '€');
    
    public static function setUpBeforeClass()
    {
        self::$validatorOne = new Validator\MinStringLength(1);
        self::$validatorTwo = new Validator\MinStringLength(2);
    }
    
    public function testGetMin()
    {       
        $this->assertSame(1, self::$validatorOne->getMin());
    }
    
    public function testCastToInteger()
    {
        $validator = new Validator\MinStringLength('1');
        
        $this->assertSame(1, $validator->getMin());
    }
    
    public function testSingleByteSuccess()
    {
        $this->assertTrue(self::$validatorOne->isValid($this->singleBytes[0]));
    }
    
    public function testSingleByteFailure()
    {
        $this->assertFalse(self::$validatorTwo->isValid($this->singleBytes[0]));
    }
    
    public function testMultiByteSuccess()
    {
        foreach ($this->multiBytes as $byte) {
            $this->assertTrue(self::$validatorOne->isValid($byte));
        }
    }
    
    public function testMultiByteFailure()
    {
        foreach ($this->multiBytes as $byte) {
            $this->assertFalse(self::$validatorTwo->isValid($byte));
        }
    }   
}