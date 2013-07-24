<?php
namespace Vision\Form\Decorator;

use Vision\Html\Element;

class Li extends HtmlTag 
{		
    protected $placement = self::WRAP;
    
    public function __construct()
    {
        $li = new Element('li');
        
        $this->decorator = $li;
    }
}