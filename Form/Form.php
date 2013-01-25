<?php 
namespace Vision\Form;

use Vision\Http\Request;
use Vision\Html\Element as HtmlElement;
use Vision\View\Html\ElementAbstract as HtmlElementViewAbstract;
use RecursiveIteratorIterator;

class FormException extends \Exception 
{
}

class Form extends AbstractCompositeType 
{    
    protected $tag = 'form';
    
    protected $attributes = array(
                                'action' => '',
                                'enctype' => 'multipart/form-data',
                                'method' => 'post'
                            );
                            
    protected $data = null;
    
    public function getContent() 
    {
        $content = '';
        foreach ($this->elements as $element) {
            $content .= $element;
        }
        return $content;
    }
    
    public function getElement($name) 
    {
        $formElementsIterator = new Iterator\FormElementsIterator($this->elements);             
        
        $recursiveIteratorIterator = new RecursiveIteratorIterator($formElementsIterator);
        
        foreach ($recursiveIteratorIterator as $key => $element) {
            if ($element->getName() === $name) {
                return $element;
            }            
        } 
        return null;
    }
    
    /**
    * Extract value by html array notation.
    *
    * @param string $name
    *
    * @return string|string
    */  
	public function extractValue($name) 
    {
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }
		$parts = explode('[', $name);
		$value = $this->data;
		foreach ($parts as $part) {
			$part = trim($part, ']');
			if (isset($value[$part])) {
				$value = $value[$part];
			} else {
				return null;
			}
		} 
		return $value;
	}

    /**
     * Process form
     *
     * http://www.w3.org/TR/html401/interact/forms.html#h-17.3
     *
     * @return bool
     */
	public function process(Request $request) 
    {         
        $isValid = true;    
        
        $method = $request->getMethod();     
        $method = strtoupper($method);
        
        switch ($method) {
            case 'GET':
                $data = $request->get->getAll();
                break;
            
            case 'POST':
                $data = $request->post->getAll();
                break;
                
            default:
                throw new Exception(sprintf('The request method "%s" is not supported by form.', $method));
        }      
        
        $this->data = $data;
        
        $formElementsIterator = new Iterator\FormElementsIterator($this->elements);             
        
        $recursiveIteratorIterator = new RecursiveIteratorIterator($formElementsIterator);
        
        foreach ($recursiveIteratorIterator as $key => $element) {
            $value = $this->extractValue($element->getName());
            if ($element->isValid($value) === false) {
                $isValid = false;
            }
        }  

        return $isValid;
	}
}