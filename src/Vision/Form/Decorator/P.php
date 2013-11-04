<?php
namespace Vision\Form\Decorator;

use Vision\Html\Element;

class P extends HtmlTag
{
    protected $placement = self::WRAP;

    public function __construct()
    {
        $paragraph = new Element('p');

        $this->decorator = $paragraph;
    }
}
