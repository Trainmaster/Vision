<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\File;

/**
 * FileSystem
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class FileSystem
{
    /** @type array */
    protected $aliases = array();
    
    /** @type null|string $dirs */
    protected $currentDir = null;
    
    /**
     * @api
     *
     * @param string $alias 
     * @param string $path 
     * 
     * @return FileSystem Provides a fluent interface.
     */
    public function addAlias($alias, $path)
    {
        $this->aliases[$alias] = $path;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param string $alias 
     * 
     * @return string|null
     */
    public function getAlias($alias)
    {
        if (isset($this->aliases[$alias])) {
            return $this->aliases[$alias];
        }
        return null;
    }
    
    /**
     * @api
     * 
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }
    
    /**
     * @api
     * 
     * @param string $source 
     * @param string $dest 
     * 
     * @return bool
     */
    public function move($source, $dest)
    {
        if (is_uploaded_file($source)) {
            return move_uploaded_file($source, $dest);
        }
        return rename($source, $dest);
    }
    
    /**
     * @api
     * 
     * @param string $dir 
     * 
     * @return bool
     */
    public function chdir($dir)
    {
        return $this->setCurrentDir($dir);
    }
    
    /**
     * @api
     *
     * @param string $dir 
     * 
     * @return bool
     */
    public function setCurrentDir($dir)
    {
        if (is_dir($dir)) {
            $this->currentDir = $dir;
            return true;
        }
        return false;
    }
    
    /**
     * @api
     *
     * @param string $source 
     * @param string $newName  
     * 
     * @return bool
     */
    public function moveHere($source, $newName = null)
    {
        if ($this->currentDir === null) {
            return false;
        }
        
        if ($newName === null) {
            return $this->move($source, $this->currentDir . DIRECTORY_SEPARATOR . basename($source));
        }
        
        return $this->move($source, $this->currentDir . DIRECTORY_SEPARATOR . $newName);
    }
}