<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form;

use Vision\Form\Decorator\DecoratorInterface;
use Vision\Validator\ValidatorInterface;

/**
 * AbstractCompositeType
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractCompositeType extends AbstractType
{
    /** @type array $elements */
    protected $elements = array();

    /**
     * @api
     *
     * @return string
     */
    public function getContents()
    {
        $content = '';

        foreach ($this->elements as $element) {
            $content .= $element;
        }

        return $content;
    }

    /**
     * @api
     *
     * @param mixed $element
     *
     * @return $this Provides a fluent interface.
     */
    public function addElement(AbstractType $element)
    {
        $this->elements[] = $element;
        return $this;
    }

    /**
     * @api
     *
     * @param array $elements
     *
     * @return $this Provides a fluent interface.
     */
    public function addElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getElements()
    {
        return parent::getChildren();
    }
}
