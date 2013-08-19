<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection\Config;

use Vision\DependencyInjection as DI;
use Vision\File\Loader\ScopeFileLoader;

/**
 * NativeLoader
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class NativeLoader extends ScopeFileLoader
{   
    /** @type string $scopeName */
    protected $scopeName = 'container';
    
    /**
     * @param DI\Container $container 
     * 
     * @return void
     */
    public function __construct(DI\Container $container)
    {
        $this->scope = $container;
    }
}