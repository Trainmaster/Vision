<?php
namespace Vision\View;

use Vision\File\FileInfo;
use RuntimeException;

class HtmlView extends AbstractView
{  
    protected $container = null;

	protected $blocks = array();
    
	protected $parent = null;
    
	protected $template = null;
    
    protected $stack = array();
    
    protected $bufferTree = array();
		    	
    public function __call($name, $array) 
    {
        if (isset($this->container)) {
            return $this->container->get($name);
        }
    }   

    public function __toString() 
    {		         
        if ($this->template === null) {
            return parent::__toString();
        }    
        
        $currentBuffer = '';          
        $file = new FileInfo($this->template); 
        
        if ($file->isLoadable()) {
            ob_start(); 
            
            include $file->getRealPath(); 
            
            if (isset($this->parent)) {
                $parent = new self;
                $parent->vars = $this->vars;
                $parent->template = $file->getPath() . DIRECTORY_SEPARATOR . $this->parent;
                $parent->container = $this->container;
                $parentBuffer = $parent->__toString();
            } 
            
            $currentBuffer = ob_get_clean();    
            
            if (!empty($this->stack)) {
                 // throw new RuntimeException(sprintf('The blocks are not properly closed'));
            }
            
            //print '<pre>';
            //print_r ($this->bufferTree);

            if (isset($parent)) {
                foreach ($this->bufferTree as $key => &$value) {                    
                    if (isset($parent->bufferTree[$key])) {
                        $extract = substr($currentBuffer, $value['start'], $value['length']);
                        
                        $parentBuffer = substr_replace($parentBuffer, $extract, $parent->bufferTree[$key]['start'], $parent->bufferTree[$key]['length']); 

                        $diff = $value['length'] - $parent->bufferTree[$key]['length'];
                        
                        $parent->bufferTree[$key]['length'] += $diff;
                        
                        foreach ($parent->bufferTree as $key2 => &$value2) {                           
                            if ($value2['start'] > $parent->bufferTree[$key]['start']) {
                                $value2['start'] += $diff;
                            }
                        }
                    } elseif (isset($this->parent) && $value['parent'] === 'root') {
                        unset($this->bufferTree[$key]);
                    } else {
                        $bar = $this->bufferTree[$value['parent']]['start'];
                        $foo = $value['start'] - $bar;
                        $parent->bufferTree[$key] = array(
                            'start' => $parent->bufferTree[$value['parent']]['start'] + $foo,
                            'length' => $value['length'],
                            'parent' => $value['parent']
                        );
                    }
                }                
                $this->bufferTree = $parent->bufferTree;
                $currentBuffer = $parentBuffer;
            }
            unset($parent);
        }      
        return $currentBuffer;        
    }
    
    public function setContainer($container) 
    {
        $this->container = $container;
        return $this;
    }
    
    public function extend($parent) 
    {
        print $parent;
        print $this->template;
        if ($this->template === $parent) {
            //throw new RuntimeException(sprintf('No output before calling "%s".', __METHOD__));
        }
        
        $length = ob_get_length();
        
        if ($length > 0) {
            //throw new RuntimeException(sprintf('No output before calling "%s".', __METHOD__));
        }
        
		$this->parent = $parent;
        
        return $this;
	}
    
	public function startBlock($block) 
    {	
        if (isset($this->blocks[$block])) {            
            // throw new RuntimeException(sprintf('The block "%s" is already defined', $block));
        }
        
        $this->blocks[$block] = true;
        
        $length = ob_get_length();
        
        if ($length !== false) {
            $this->bufferTree[$block]['start'] = $length;            
        }
        
        $this->stack[] = $block;
        
        return $this;
	}
	
	public function endBlock() 
    {
        $length = ob_get_length();
        
        if ($length !== false) {
            $block = array_pop($this->stack);   

            $lastElement = end($this->stack);
            
            $this->bufferTree[$block]['length'] = $length - $this->bufferTree[$block]['start'];         

            if ($lastElement !== false) {
                $this->bufferTree[$block]['parent'] = $lastElement;    
            } else {
                $this->bufferTree[$block]['parent'] = 'root';
            }            
        }    
        
        return $this;  
	}
    
    public function showParent()
    {
        $lastElement = end($this->stack);
        var_Dump ($lastElement);
        var_dump('Parent');
    }
    
    public function setTemplate($template) 
    {
		$this->template = (string) $template;
		return $this;
	}
    
    public function escape($value) 
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}