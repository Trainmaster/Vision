<?php
namespace Vision\Form\Decorator;

use Vision\Html\Element as HtmlElement;

class HtmlTag extends DecoratorAbstract 
{
    protected $decorator = null;
    
    protected $placement = self::PREPEND;           
    
    public function getDecorator()
    {
        return $this->decorator;
    }

    public function render($content) 
    {       
        $html = '';
        switch ($this->placement) {   
            case self::PREPEND:
                $html = $this->decorator . $content;
                break;
                
            case self::WRAP:
                if ($this->decorator->isVoid()) {
                    return $content;
                }
                $this->decorator->addContent($content);
                $html = (string) $this->decorator;
                break;
                
            case self::APPEND:
                $html = $content . $this->decorator;
                break;
                
            default:
                return $content;
        }

        return $html;   
    }
}