<?php
namespace Vision\Form\Decorator;

use Vision\Html\ElementFactory;

class Ul extends HtmlTag 
{		
    protected $placement = self::WRAP;

	public function __construct()
    {
        $ul = ElementFactory::create('ul');
        
        $this->decorator = $ul;
    }
}