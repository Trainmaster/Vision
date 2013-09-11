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
 * AbstractRoute
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractRoute
{        
    /** @type array $defaults */
    protected $defaults = array();
    
    /** @type array $requirements */
    protected $requirements = array();
        
    /**
     * @api
     * 
     * @param array $defaults 
     * 
     * @return AbstractRoute Provides a fluent interface.
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
     * @return AbstractRoute Provides a fluent interface.
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