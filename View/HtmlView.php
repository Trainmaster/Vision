<?php
namespace Vision\View;

use Vision\File\FileInfo;
use RuntimeException;

class HtmlView extends AbstractView
{  
    protected $container = null;
    
    public $blocks = array();
    
    protected $parent = null;
    
    protected $template = null;
    
    protected $stack = array();
    
    protected $insertions = array();
		    	
    public function __call($name, $array) 
    {
        if (isset($this->container)) {
            return $this->container->get($name);
        }
    }   

    public function render() 
    {		         
        if ($this->template === null) {
            throw new RuntimeException('A template file must be provided.');
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
                $parentBuffer = $parent->render();
            }
            
            $currentBuffer = ob_get_clean();
            
            if (!empty($this->stack)) {
                throw new RuntimeException(sprintf(
                    'The blocks are not properly closed in "%s".',
                    $this->template
                ));
            }

            if (isset($parent)) {
                if (!empty($this->insertions)) {
                    foreach($this->insertions as $key => $value) {
                        if (isset($parent->blocks[$value['parent']])) {
                            $extract = substr($parentBuffer, $parent->blocks[$value['parent']]['start'], $parent->blocks[$value['parent']]['length']);
                            $currentBuffer = substr_replace($currentBuffer, $extract, $value['start'], 0);
                            $diff = $parent->blocks[$value['parent']]['length'];                           
                            foreach ($this->blocks as $key2 => &$value2) {
                                if ($value2['start'] > $value['start']) {
                                    $value2['start'] += $diff;
                                }
                            }                            
                            $this->recurse($value, $diff);
                        }
                    }
                    unset($this->insertions[$key]);
                }   
                
                if (!empty($this->blocks)) {
                    $max = 0;
                    foreach ($this->blocks as $key => &$value) {                       
                        if (isset($parent->blocks[$key])) {
                            if ($value['start'] < $max) {
                                $parent->blocks[$key]['start'] = $value['start'] + $parent->blocks[$value['parent']]['start'];
                                $parent->blocks[$key]['length'] = $value['length'];
                                continue;
                            }
                            $extract = substr($currentBuffer, $value['start'], $value['length']);

                            $parentBuffer = substr_replace($parentBuffer, $extract, $parent->blocks[$key]['start'], $parent->blocks[$key]['length']); 
                            $diff = $value['length'] - $parent->blocks[$key]['length'];
                            
                            $len = $parent->blocks[$key]['start'] + $parent->blocks[$key]['length'];
                            
                            $parent->blocks[$key]['length'] += $diff;     

                            foreach ($parent->blocks as $key2 => &$value2) {   
                                if ($value2['start'] > $len) {                                    
                                    $value2['start'] += $diff;
                                }
                            }
                        } elseif (isset($this->parent) && $value['parent'] === 'root') {
                            unset($this->blocks[$key]);
                        } else {
                            $bar = $this->blocks[$value['parent']]['start'];
                            $foo = $value['start'] - $bar;
                            $parent->blocks[$key] = array(
                                'start' => $parent->blocks[$value['parent']]['start'] + $foo,
                                'length' => $value['length'],
                                'parent' => $value['parent']
                            );
                        }
                        $max = $value['start'] + $value['length'];  
                    }
                    
                }
                                
                $this->blocks = $parent->blocks;
                $currentBuffer = $parentBuffer;
            }
            unset($parent);
        }      
        return $currentBuffer;        
    }
    
    public function recurse(array $array, $diff)
    {
        if (isset($array['parent']) && $array['parent'] !== 'root') {
            $this->blocks[$array['parent']]['length'] += $diff; 
            return $this->recurse($this->blocks[$array['parent']], $diff);
        }              
    }
    
    public function setContainer($container) 
    {
        $this->container = $container;
        return $this;
    }
    
    public function extend($parent) 
    {
        if ($this->template === $parent) {
            throw new RuntimeException(sprintf('Recursion in "%s".', __METHOD__));
        }
        
        $length = ob_get_length();
        
        if ($length > 0) {
            throw new RuntimeException(sprintf('No output before calling "%s".', __METHOD__));
        }
        
		$this->parent = $parent;
        
        return $this;
	}
    
    public function startBlock($block)
    {	
        if (isset($this->blocks[$block])) {            
            throw new RuntimeException(sprintf(
                'The block "%s" is already defined in "%s"', 
                $block,
                $this->template
            ));
        }
        
        $length = ob_get_length();
        
        if ($length !== false) {
            $this->blocks[$block]['start'] = $length;            
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
            
            $this->blocks[$block]['length'] = $length - $this->blocks[$block]['start'];         

            if ($lastElement !== false) {
                $this->blocks[$block]['parent'] = $lastElement;    
            } else {
                $this->blocks[$block]['parent'] = 'root';
            }            
        }    
        
        return $this;
    }
    
    public function parent()
    {
        $lastElement = end($this->stack);
        if ($lastElement === false) {
            throw new RuntimeException(sprintf('Call to "%s" outside of a block is not allowed.', __FUNCTION__));
        }
        $this->insertions[] = array(
            'start' => ob_get_length(),
            'length' => 0,
            'parent' => $lastElement
        );
        return $this;
    }
    
    public function block($block)
    {
        if (in_array($block, $this->stack, true)) {
            //throw new RuntimeException(sprintf('Recursion %s.', __FUNCTION__));
        }
        //var_dump($this->stack);
        //var_dump($block);
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