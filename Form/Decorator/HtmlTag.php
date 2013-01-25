<?php
namespace Vision\Form\Decorator;

use Vision\Html\Element;

class HtmlTag extends DecoratorAbstract 
{
    protected $decorator = null;
    
    protected $placement = self::PREPEND;		    

    public function __construct(Element $decorator = null) 
    {
        $this->decorator = $decorator;
    }

	public function render($content) 
    {		            
		switch ($this->placement) {   
            case self::PREPEND:
				$html = $this->decorator . $content;
				break;
                
            case self::EMBED:
                $this->decorator->setContent($content);
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