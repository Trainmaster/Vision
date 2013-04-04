<?php
namespace Vision\Form\Decorator;

use Vision\Html\ElementFactory;

class Li extends HtmlTag 
{		
    protected $placement = self::WRAP;
    
    public function __construct()
    {
        $li = ElementFactory::create('li');
        
        $this->decorator = $li;
    }
}