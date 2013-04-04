<?php
namespace Vision\Form\Decorator;

use Vision\Html\ElementFactory;

class P extends HtmlTag 
{		
    protected $placement = self::WRAP;
    
    public function __construct()
    {
        $paragraph = ElementFactory::create('p');
        
        $this->decorator = $paragraph;
    }
}