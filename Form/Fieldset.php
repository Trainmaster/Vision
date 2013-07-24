<?php 
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form;

use Vision\Http\Request;
use Vision\Html\Element;
use Vision\Form\Control\ControlAbstract;

/**
 * Fieldset
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
class Fieldset extends AbstractCompositeType
{
    protected $tag = 'fieldset';
        
    protected $legend = null;
    
    public function init()
    {
        $this->addDecorator(new Decorator\Ul);
    }
        
    public function getContents() 
    {
        $content = parent::getContents();

        if ($this->legend) {
            $legend = new Element('legend');
            $legend->addContent($this->legend);
            $content = $legend . $content;
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