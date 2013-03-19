<?php
namespace Vision\File\Loader;

class ScopeFileLoader extends AbstractFileLoader
{
    protected $scope = null;
    
    protected $scopeName = null;
    
    public function load($file)
    {
        if ($this->isLoadable($file)) {
            ${$this->scopeName} = $this->scope;
            include $file;
        }
    }
}