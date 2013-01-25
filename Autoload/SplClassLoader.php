<?php
namespace Vision\Autoload;

use RuntimeException;

class SplClassLoader 
{	
    protected $fileExtension = '.php';
    
    protected $namespace = null;
    
    protected $namespaceSeparator = '\\';
    
    protected $path = null;
    
    public function __construct($namespace, $path) 
    {
        $this->setNamespace($namespace);
        $this->setPath($path);
    }
    
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = (string) $fileExtension;
        return $this;
    }
    
    public function getFileExtension() 
    {
        return $this->fileExtension;
    }
    
    public function setNamespace($namespace) 
    {
        $this->namespace = (string) $namespace;
        return $this;
    }
    
    public function getNamespace() 
    {
        return $this->namespace;
    }
    
    public function setNamespaceSeparator($namespaceSeparator) 
    {
        $this->namespaceSeparator = (string) $namespaceSeparator;
        return $this;
    }
    
    public function getNamespaceSeparator()
    {
        return $this->namespaceSeparator;
    }
    
    public function setPath($path)
    {   
        $this->path = (string) $path;
        return $this;
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function load($class) 
    {
        $hasNamespace = strpos($class, $this->namespace . $this->namespaceSeparator);
        if ($hasNamespace === 0) {
            $class = strtr($class, $this->namespaceSeparator, DIRECTORY_SEPARATOR);
            
            $fileName = $this->path . DIRECTORY_SEPARATOR . $class . $this->fileExtension;
            
            if (is_file($fileName) === false) {
                throw new RuntimeException(sprintf('The file "%s" does not exist and/or is not a file.', $fileName));
            }
            
            if (is_readable($fileName) === false) {
                throw new RuntimeException(sprintf('The file "%s" is not readable.', $fileName));
            }
            
            return include $fileName;
        }
    }
    
    public function register($prepend = false) 
    {
        spl_autoload_register(array($this, 'load'), true, $prepend);
    }
    
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'load'));
    }
}