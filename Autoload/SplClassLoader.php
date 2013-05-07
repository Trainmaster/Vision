<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Autoload;

use RuntimeException;

/**
 * SplClassLoader
 *
 * @author Frank Liepert
 */
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
            $class = str_replace($this->namespaceSeparator, DIRECTORY_SEPARATOR, $class);
            
            $fileName = $this->path . DIRECTORY_SEPARATOR . $class . $this->fileExtension;

            if (stream_resolve_include_path($fileName)) {
                return include $fileName;
            }           
        }
        return false;
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