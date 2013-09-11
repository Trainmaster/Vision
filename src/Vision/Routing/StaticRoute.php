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
 * StaticRoute
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class StaticRoute extends AbstractCompiledRoute
{
    /** @type string $path */
    protected $path = null;
    
    /**
     * @param string $path 
     * @param string $class 
     * @param string $method 
     */
    public function __construct($path, $class, $method)
    {
        $this->path = trim($path);
        
        parent::setClass($class);
        
        if (isset($method)) {
            parent::setMethod($method);
        }
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
}