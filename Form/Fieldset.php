<?php 
namespace Vision\Form;

use Vision\Http\Request;
use Vision\Html\Element as HtmlElement;
use Vision\View\Html\ElementAbstract as HtmlElementViewAbstract;
use Vision\Form\Control\ControlAbstract;

class Fieldset extends AbstractCompositeType {

    protected $tag = 'fieldset';
        
    protected $legend = null;
        
    public function getContent() 
    {
        $content = '';
        if ($this->legend !== null) {
            $legend = new HtmlElement('legend');
            $legend->setContent($this->legend);
            $content .= $legend;
        }
		foreach ($this->elements as $element) {
			$content .= (string) $element;
		}
        return $content;
    }

    public function setLegend($legend) {
        $this->legend = $legend;
        return $this;
    }
    
    public function getLegend() {
        return $this->legend;
    }
}