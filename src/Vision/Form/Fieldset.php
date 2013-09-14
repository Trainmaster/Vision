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
    /** @type string $tag */
    protected $tag = 'fieldset';
      
    /** @type null|string $legend */      
    protected $legend = null;
    
    /**
     * @return void
     */
    public function init()
    {
        $this->addDecorator(new Decorator\Ul);
    }
        
    /**
     * @api
     * 
     * @return mixed
     */
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

    /**
     * @api
     * 
     * @param string $legend 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setLegend($legend) {
        $this->legend = $legend;
        return $this;
    }
    
    /**
     * @api
     * 
     * @return string
     */
    public function getLegend() {
        return $this->legend;
    }
}