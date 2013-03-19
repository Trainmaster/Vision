<?php
namespace Vision\View;

use Vision\File\FileInfo;
use RuntimeException;

class TemplateEngine 
{
    protected $tplPath = null;
    
    protected $loadedTemplates = array();
    
    public function __construct($tplPath = null)
    {
        if (isset($tplPath)) {
            $this->tplPath = $tplPath;
        }
    }
    
    protected function loadTemplate($template)
    {
        
        
    }
    
    public function render($template, $test = false)
    {   print '<pre>';
        var_dump($template);
        
        if (isset($this->loadedTemplates[$template])) {
            $tpl = $this->loadedTemplates[$template];
        } else {     
            $tpl = new Template;
            $tpl->setTemplate($this->tplPath . DIRECTORY_SEPARATOR . $template);
        }
        
        
        $currentBuffer = $tpl->testRender();
        var_dump($tpl);
        if ($test === true) {
            return $tpl;
        }

        if ($tpl->getParent() !== null) {
            $parent = $this->render($tpl->getParent(), true);
            $parentBuffer = $parent->testRender();
        }

        /*if (isset($tpl->parent)) {
            $parent = new self;
            $parent->vars = $this->vars;
            $parent->template = $file->getPath() . DIRECTORY_SEPARATOR . $this->parent;
            $parent->container = $this->container;
            $parentBuffer = $parent->render();
        }*/         
        
        /*if (!empty($this->stack)) {
            throw new RuntimeException(sprintf(
                'The blocks are not properly closed in "%s".',
                $template
            ));
        }*/

        if (isset($parent)) {
            if (!empty($tpl->insertions)) {
                foreach($tpl->insertions as $key => $value) {
                    if (isset($parent->blocks[$value['parent']])) {
                        $extract = substr($parentBuffer, $parent->blocks[$value['parent']]['start'], $parent->blocks[$value['parent']]['length']);
                        $currentBuffer = substr_replace($currentBuffer, $extract, $value['start'], 0);
                        $diff = $parent->blocks[$value['parent']]['length'];                           
                        foreach ($tpl->blocks as $key2 => &$value2) {
                            if ($value2['start'] > $value['start']) {
                                $value2['start'] += $diff;
                            }
                        }                            
                        $tpl->recurse($value, $diff);
                    }
                }
                unset($tpl->insertions[$key]);
            }   
            
            if (!empty($tpl->blocks)) {
                $max = 0;
                foreach ($tpl->blocks as $key => &$value) {                       
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
                    } elseif (isset($tpl->parent) && $value['parent'] === 'root') {
                        unset($tpl->blocks[$key]);
                    } else {
                        $bar = $tpl->blocks[$value['parent']]['start'];
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
                            
            $tpl->blocks = $parent->blocks;
            $currentBuffer = $parentBuffer;
        }
        
        $this->loadedTemplates[$template] = $tpl;
        
        unset($parent);
    
        return $currentBuffer;        
    }
}