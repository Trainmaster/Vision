<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection;

use Vision\DependencyInjection\Dependency;

use InvalidArgumentException;

/**
 * Definition
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Definition 
{
    /** @type null|string $class */
    protected $class = null;
    
    /** @type bool $shared */
    protected $shared = true;
    
    /** @type array $constructor */
    protected $constructor = array();
    
    /** @type array $property */
    protected $property = array();
    
    /** @type array $setter */
    protected $setter = array();
        
    /**
     * @param string $class 
     * 
     * @return void
     */
    public function __construct($class)
    {
        $this->setClass($class);
    }    
    
    /**
     * @param string $class  
     * 
     * @return Definition Provides a fluent interface.
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getClass() 
    {
        return $this->class;
    }
    
    /**
     * @param bool $shared 
     * 
     * @return Definition Provides a fluent interface.
     */
    public function setShared($shared)
    {
        $this->shared = (bool) $shared;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isShared()
    {
        return $this->shared;
    }
    
    /**
     * @param array $constructor 
     * 
     * @return Definition Provides a fluent interface.
     */
    public function constructor(array $constructor) 
    {   
        $this->constructor = $constructor;
        return $this;
    }
    
    /**
     * @param string $property 
     * @param mixed $value 
     * 
     * @return Definition Provides a fluent interface.
     */
    public function property($property, $value) 
    {
        if (is_string($property) === false) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->property[$property] = $value;
        return $this;
    }
    
    /**
     * @param string $setter 
     * @param array $dependencies 
     * 
     * @return Definition Provides a fluent interface.
     */
    public function setter($setter, array $dependencies) 
    {
        if (is_string($setter) === false) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be a string.',
                __METHOD__
            ));
        }
        $this->setter[][$setter] = $dependencies;
        return $this;
    } 
    
    /**
     * @param array $setter 
     * 
     * @return Definition Provides a fluent interface.
     */
    public function setSetter(array $setter)
    {
        $this->setter = $setter;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getConstructorInjections() 
    {   
        return $this->constructor;
    }
    
    /**
     * @return array
     */
    public function getPropertyInjections() 
    {
        return $this->property;
    }
    
    /**
     * @return array
     */
    public function getSetterInjections() 
    {
        return $this->setter;
    } 
}