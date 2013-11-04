<?php
namespace Vision\Form\Decorator;

use Vision\Html\Element;

class Ul extends HtmlTag
{
    protected $placement = self::WRAP;

	public function __construct()
    {
        $ul = new Element('ul');

        $this->decorator = $ul;
    }
}
