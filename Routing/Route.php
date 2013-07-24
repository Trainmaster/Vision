<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Routing;

/**
 * Route
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Route
{
    /** @type bool $isStatic */
    protected $isStatic = true;
    
    /** @type string $path */
    protected $path = null;
    
    /** @type string $controller */
    protected $controller = null;
    
    /** @type array $requirements */
    protected $requirements = array();
    
    /** @type array $defaults */
    protected $defaults = array();
    
    /**
     * @param string $path 
     * @param string $controller 
     * 
     * @return void
     */
    public function __construct($path, $controller)
    {        
        $this->setPath($path);
        $this->setController($controller);
    }
    
    /**
     * @api
     * 
     * @return bool
     */
    public function isStatic()
    {
        return $this->isStatic;
    }
    
    /**
     * The character "{" indicates, if the route contains dynamic parts.
     *
     * @api
     *
     * @param string $path 
     * 
     * @return Route Provides a fluent interface.
     */
    public function setPath($path)
    {
        if (strpos($path, '{') >= 0) {
            $this->isStatic = false;
        }
        
        $this->path = trim($path);
        
        return $this;
    }
    
    /**
     * @api
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    public function getStaticPath()
    {
        $pos = strpos($this->path, '{');
        
        if ($pos >= 0) {
            return substr($this->path, 0, $pos - 1);
        }
    }

    /**
     * @api
     *
     * @param string $controller 
     * 
     * @return Route Provides a fluent interface.
     */
    public function setController($controller)
    {
        $this->controller = trim($controller);
        return $this;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }
    
    /**
     * @api
     * 
     * @param array $defaults 
     * 
     * @return Route Provides a fluent interface.
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * @api
     * 
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }
    
    /**
     * @api
     * 
     * @param array $requirements 
     * 
     * @return Route Provides a fluent interface.
     */
    public function setRequirements(array $requirements)
    {
        $this->requirements = $requirements;
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }
}