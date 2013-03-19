<?php
namespace Vision\DependencyInjection\Config;

use Vision\DependencyInjection as DI;
use Vision\File\Loader\ScopeFileLoader;

class NativeLoader extends ScopeFileLoader
{   
    protected $scopeName = 'container';
    
    public function __construct(DI\Container $container)
    {
        $this->scope = $container;
    }
}