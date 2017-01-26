<?php
namespace Vision\Form;

/**
 * AbstractCompositeType
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractCompositeType extends AbstractType
{
    /**
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
     * @param AbstractType $element
     *
     * @return $this Provides a fluent interface.
     */
    public function addElement(AbstractType $element)
    {
        $this->elements[] = $element->setParent($this);
        return $this;
    }

    /**
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
     * @return array
     */
    public function getElements()
    {
        return parent::getChildren();
    }

    /**
     * @param $name
     */
    public function removeElementByName($name)
    {
        foreach ($this->elements as $key => $element) {
            if ($element->getName() === $name) {
                unset($this->elements[$key]);
            }
        }
    }
}
