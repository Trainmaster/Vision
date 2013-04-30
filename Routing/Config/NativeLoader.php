<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Routing\Config;

use Vision\Routing\Router;
use Vision\File\Loader\ScopeFileLoader;

/**
 * NativeLoader
 *
 * @author Frank Liepert
 */
class NativeLoader extends ScopeFileLoader
{   
    protected $scopeName = 'router';
    
    public function __construct(Router $router)
    {
        $this->scope = $router;
    }
}