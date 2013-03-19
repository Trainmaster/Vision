<?php
namespace Vision\Routing\Config;

use Vision\Routing\Router;
use Vision\File\Loader\ScopeFileLoader;

class NativeLoader extends ScopeFileLoader
{   
    protected $scopeName = 'router';
    
    public function __construct(Router $router)
    {
        $this->scope = $router;
    }
}