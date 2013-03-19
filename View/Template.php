<?php
namespace Vision\View;

use Vision\File\FileInfo;
use RuntimeException;

class Template
{    
    protected $buffer = null;
    
    protected $file = null;
    
    protected $parent = null;
    
    protected $vars = array();
    
    protected $blocks = array();
    
    protected $stack = array();
    
    public function __construct()
    {
    }
    
    public function __set($key, $value)
    {
        $this->vars[$key] = $value;
        $this->blocks['@' . $key]['length'] = strlen($value);
        return $this;
    }
    
    public function __get($key)
    {
        if (isset($this->vars[$key])) {
            $this->blocks['@' . $key]['start'] = ob_get_length();
            return $this->vars[$key];
        }
        return null;
    }    
    
    public function extend($parent)
    {
        $length = ob_get_length();
        
        if ($length > 0) {
            throw new RuntimeException(sprintf('No output before calling "%s" in "%s".', __FUNCTION__, $this->file));
        }
        
        if ($this->file === $parent) {
            throw new RuntimeException(sprintf('Infinite loop in "%s". A template file may not extend itself.', $this->file));
        }
        
        $this->parent = $parent;
        return $this;
    }
    
    public function startBlock($name)
    {
        $this->blocks[$name]['start'] = ob_get_length();
        $this->stack[] = $name;
        return $this;
    }
    
    public function endBlock()
    {
        $name = array_pop($this->stack);   
        $this->blocks[$name]['end'] = ob_get_length();
        return $this;
    }
    
    public function render($file = null)
    {
        if (isset($this->buffer)) {
            var_dump('Use Buffer');
            var_dump($this->buffer);
            print_r($this->blocks);
            print_r ($this->vars);
            foreach ($this->vars as $key => $value) {               
                $key = '@' . $key; 
            }
            return $this->buffer;
        }
        
        if (isset($file)) {
            var_dump('Create Buffer');
            $this->file = (string) $file;
            
            ob_start();
            
            include TPL_PATH . DIRECTORY_SEPARATOR . $this->file;
            
            $this->buffer = ob_get_clean();       
            
            print '<pre>';            
            
            // To do: Add description, which blocks are not closed
            if (!empty($this->stack)) {                
                throw new RuntimeException(sprintf('Block(s) not properly closed in "%s".', $this->file));
            }
        }
    }
}