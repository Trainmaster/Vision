<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Form\Validator;

use Vision\Form\AbstractCompositeType;
use Vision\Validator\ValidatorAbstract;

use InvalidArgumentException;

/**
 * ValueMatch
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class ValueMatch extends ValidatorAbstract 
{
    /** @type string NO_MATCH */
    const NOT_UNIQUE = 'The given controls do not match.';
    
    /** @type array $controls */
    protected $controls = array();
    
    /**
     * @api
     * 
     * @param array $controls 
     * 
     * @return ValueMatch Provides a fluent interface.
     */
    public function setControls(array $controls)
    {
        $this->controls = $controls;
        
        return $this;
    }
    
    /**
     * @api
     * 
     * @param AbstractCompositeType $form 
     * 
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function isValid($form) 
    {
        if (!($form instanceof AbstractCompositeType)) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to %s must be an instance of %s.',
                __METHOD__,
                get_class('AbstractCompositeType')
            ));
        }
        
        foreach ($this->controls as $control) {
            $values[] = $form->getValue($control);
        }
        
        $unique = array_unique($values);
        
        $count = count($unique);
        
        if ($count === 1) {
            return true;
        }
        
        $this->addError(self::NOT_UNIQUE)
             ->addError(array('controls' => $this->controls));
        
        return false;                
    }
}